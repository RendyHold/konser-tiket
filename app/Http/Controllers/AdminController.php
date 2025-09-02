<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class AdminController extends Controller
{
    // List tiket yang sudah discan + filter sederhana
    public function scans(Request $request)
    {
        $q = Ticket::with(['user','scannedBy'])
            ->whereNotNull('scanned_at')
            ->latest('scanned_at');

        if ($request->filled('q')) {
            $term = $request->q;
            $q->where(function($s) use ($term){
                $s->where('code','like',"%$term%")
                  ->orWhereHas('user', fn($u)=>$u->where('name','like',"%$term%"));
            });
        }
        if ($request->filled('from')) $q->whereDate('scanned_at','>=',$request->from);
        if ($request->filled('to'))   $q->whereDate('scanned_at','<=',$request->to);

        $tickets = $q->paginate(20)->withQueryString();
        return view('admin.scans', compact('tickets'));
    }

    // List user + aksi ubah role petugas
    public function users()
    {
        $users = User::orderBy('name')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function makePetugas(User $user)
    {
        $user->update(['role' => 'petugas']);
        return back()->with('ok','Role user diubah menjadi petugas.');
    }

    public function revokePetugas(User $user)
    {
        // Turunkan ke user biasa (tidak mengubah admin lain)
        if ($user->role === 'admin') return back()->with('err','Tidak bisa mencabut role admin lewat aksi ini.');
        $user->update(['role' => 'user']);
        return back()->with('ok','Role petugas dicabut.');
    }

    public function proofs(Request $request)
    {
        $q = Ticket::query()
            ->with(['user','scannedBy'])
            ->whereNotNull('npm_proof_path'); // hanya yang punya bukti

        // cari: kode / npm / nama user
        if ($request->filled('q')) {
            $term = trim($request->q);
            $q->where(function ($s) use ($term) {
                $s->where('code','like',"%{$term}%")
                  ->orWhere('npm','like',"%{$term}%")
                  ->orWhereHas('user', fn($u)=>$u->where('name','like',"%{$term}%"));
            });
        }

        // filter tanggal berdasarkan waktu klaim (bukti diunggah saat klaim)
        if ($request->filled('from')) $q->whereDate('claimed_at','>=',$request->from);
        if ($request->filled('to'))   $q->whereDate('claimed_at','<=',$request->to);

        $tickets = $q->orderByDesc('claimed_at')
                     ->paginate(15)
                     ->withQueryString();

        return view('admin.proofs', compact('tickets'));
    }

    public function destroyUser(User $user)
    {
        $actor = auth()->user();

        // Tidak boleh hapus diri sendiri
        if ($actor->id === $user->id) {
            return back()->with('err', 'Tidak bisa menghapus akun sendiri.');
        }

        // Petugas hanya boleh hapus akun role user
        if ($actor->role === 'petugas' && $user->role !== 'user') {
            abort(403, 'Petugas hanya dapat menghapus akun user.');
        }

        // Admin tidak boleh menghapus admin terakhir
        if ($user->role === 'admin') {
            $totalAdmin = User::where('role', 'admin')->count();
            if ($totalAdmin <= 1) {
                return back()->with('err', 'Tidak dapat menghapus admin pertama.');
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

    public function manualScanForm()
    {
    return view('admin.scans-manual');
    }

    public function manualScanStore(Request $request)
    {
    $data = $request->validate([
        'code'       => ['required','string','exists:tickets,code'],
        'scanned_at' => ['nullable','date'],
    ]);

    $ticket = Ticket::where('code',$data['code'])->firstOrFail();

    // kalau sudah discan, balikin pesan
    if ($ticket->scanned_at) {
        return back()->with('err','Tiket ini sudah discan sebelumnya.');
    }

    $ticket->update([
        'status'     => 'used',
        'scanned_at' => $data['scanned_at'] ?? now(),
        'scanned_by' => auth()->id(),
    ]);

    return redirect()->route('admin.scans')->with('ok','Scan manual berhasil disimpan.');
    }


    // === Unduh bukti ===
    public function downloadProof(Ticket $ticket)
    {
        abort_unless($ticket->npm_proof_path, 404, 'Berkas tidak ditemukan.');
        $filename = 'bukti-npm-'.$ticket->npm.'.'.pathinfo($ticket->npm_proof_path, PATHINFO_EXTENSION);
        return Storage::disk('public')->download($ticket->npm_proof_path, $filename);
    }
}