<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;

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
    public function users()
    {
        $users = User::orderBy('name')->paginate(10)->withQueryString();
        return view('admin.users', compact('users'));
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
}
