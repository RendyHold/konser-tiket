<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetRequest;


class AdminController extends Controller
{
    /**
     * Daftar tiket yang sudah discan (scan log) + filter & pagination.
     */
    public function scans(Request $request)
    {
        $q = Ticket::with(['user', 'scannedBy'])
            ->whereNotNull('scanned_at')
            ->latest('scanned_at');

        // Cari: kode / nama pemilik
        if ($request->filled('q')) {
            $term = trim($request->q);
            $q->where(function ($s) use ($term) {
                $s->where('code', 'like', "%{$term}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$term}%"));
            });
        }

        // Rentang tanggal scan
        if ($request->filled('from')) $q->whereDate('scanned_at', '>=', $request->from);
        if ($request->filled('to'))   $q->whereDate('scanned_at', '<=', $request->to);

        $tickets = $q->paginate(5)->withQueryString();   // <= 5 per halaman
        return view('admin.scans', compact('tickets'));
    }

    /**
     * Daftar pengguna + aksi ubah role.
     */
    public function users(Request $request)
    {
                // ambil query dari request
    $q       = trim((string) $request->get('q', ''));        // cari nama/email
    $role    = $request->get('role');                        // admin / petugas / user
    $perPage = (int) $request->get('perPage', 10);           // default 10

    // amankan nilai perPage
    if (! in_array($perPage, [10, 25, 50, 100], true)) {
        $perPage = 10;
    }

    $users = User::query()
        // cari di name / email
        ->when($q !== '', function ($query) use ($q) {
            $query->where(function ($w) use ($q) {
                $w->where('name',  'like', "%{$q}%")
                  ->orWhere('email','like', "%{$q}%");
            });
        })
        // filter role (kalau di tabel users ada kolom `role`)
        ->when(!empty($role), fn ($query) => $query->where('role', $role))

        // urutkan nama
        ->orderBy('name')
        ->paginate($perPage)
        ->withQueryString(); // simpan parameter filter di pagination

    // daftar role untuk dropdown di view (sesuaikan kalau beda)
    $roles = ['admin', 'petugas', 'user'];

    return view('admin.users', compact('users', 'q', 'role', 'perPage', 'roles'));

    }

    public function makePetugas(User $user)
    {
        $user->update(['role' => 'petugas']);
        return back()->with('ok', 'Role user diubah menjadi petugas.');
    }

    public function revokePetugas(User $user)
    {
        // Tidak memproses admin lewat endpoint ini
        if ($user->role === 'admin') {
            return back()->with('err', 'Tidak bisa mencabut role admin lewat aksi ini.');
        }
        $user->update(['role' => 'user']);
        return back()->with('ok', 'Role petugas dicabut.');
    }

    /**
     * Daftar bukti SIAK (hanya tiket yang punya file bukti) + filter & pagination.
     * PASTIKAN hanya ADA SATU method ini di file.
     */
    public function proofs(Request $request)
    {
        $q = Ticket::query()
            ->with(['user', 'scannedBy'])
            ->whereNotNull('npm_proof_path'); // hanya yang punya bukti

        // Cari: kode / npm / nama user
        if ($request->filled('q')) {
            $term = trim($request->q);
            $q->where(function ($s) use ($term) {
                $s->where('code', 'like', "%{$term}%")
                  ->orWhere('npm', 'like', "%{$term}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$term}%"));
            });
        }

        // Rentang berdasarkan waktu klaim (bukti diunggah saat klaim)
        if ($request->filled('from')) $q->whereDate('claimed_at', '>=', $request->from);
        if ($request->filled('to'))   $q->whereDate('claimed_at', '<=', $request->to);

        $tickets = $q->orderByDesc('claimed_at')
                     ->paginate(5)               // <= 5 per halaman
                     ->withQueryString();

        return view('admin.proofs', compact('tickets'));
    }

    /**
     * Hapus user (dengan aturan aman) + hapus tiket & file bukti miliknya.
     */
    public function destroyUser(User $user)
    {
        $actor = auth()->user();

        // Tidak boleh hapus diri sendiri
        if ($actor->id === $user->id) {
            return back()->with('err', 'Tidak bisa menghapus akun sendiri.');
        }

        // Petugas hanya boleh hapus user biasa
        if ($actor->role === 'petugas' && $user->role !== 'user') {
            abort(403, 'Petugas hanya dapat menghapus akun user.');
        }

        // Admin terakhir tidak boleh dihapus
        if ($user->role === 'admin') {
            $totalAdmin = User::where('role', 'admin')->count();
            if ($totalAdmin <= 1) {
                return back()->with('err', 'Tidak dapat menghapus admin pertama/terakhir.');
            }
        }

        // Hapus tiket & file bukti milik user (jika ada)
        $tickets = Ticket::where('user_id', $user->id)->get();
        foreach ($tickets as $t) {
            if ($t->npm_proof_path) {
                Storage::disk('public')->delete($t->npm_proof_path);
            }
        }
        Ticket::where('user_id', $user->id)->delete();

        // Hapus user
        $user->delete();

        return back()->with('ok', 'Akun berhasil dihapus.');
    }

    /**
     * Form input scan manual.
     */
    public function manualScanForm()
    {
        return view('admin.scans-manual');
    }

    /**
     * Simpan hasil scan manual.
     */
    public function manualScanStore(Request $request)
    {
        $data = $request->validate([
            'code'       => ['required', 'string', 'exists:tickets,code'],
            'scanned_at' => ['nullable', 'date'],
        ]);

        $ticket = Ticket::where('code', $data['code'])->firstOrFail();

        if ($ticket->scanned_at) {
            return back()->with('err', 'Tiket ini sudah discan sebelumnya.');
        }

        $ticket->update([
            'status'     => 'used',
            'scanned_at' => $data['scanned_at'] ?? now(),
            'scanned_by' => auth()->id(),
        ]);

        return redirect()->route('admin.scans')->with('ok', 'Scan manual berhasil disimpan.');
    }

    /**
     * Unduh file bukti SIAK.
     */
    public function downloadProof(Ticket $ticket)
    {
        abort_unless($ticket->npm_proof_path, 404, 'Berkas tidak ditemukan.');
        $ext = pathinfo($ticket->npm_proof_path, PATHINFO_EXTENSION);
        $filename = 'bukti-npm-' . $ticket->npm . '.' . $ext;

        return Storage::disk('public')->download($ticket->npm_proof_path, $filename);
    }

    /**
     * Reset password pengguna.
     */
    public function resetPassword(Request $request, User $user)
    {
    $request->validate([
        'password' => 'required|confirmed|min:8',
    ]);

    // Reset password
    $user->password = bcrypt($request->password);
    $user->save();

    return redirect()->route('admin.users')->with('success', 'Password berhasil direset!');
    }

    public function generateResetPasswordToken(User $user)
    {
        // Generate token
        $token = Str::random(60);

        // Simpan token ke database
        $user->reset_token = $token;
        $user->save();

        // Kirim email dengan link reset password
        Mail::to($user->email)->send(new PasswordResetRequest($token));

        return redirect()->back()->with('success', 'Token reset password telah dikirim ke email pengguna.');
    }

}
