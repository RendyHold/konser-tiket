<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role ?? 'user';

        /**
         * Hitung total tiket & tiket terscan.
         * Default pakai kolom scanned_at; kalau tidak ada, fallback ke status='used'.
         */
        $totalTickets = Ticket::count();

        if (Schema::hasColumn('tickets', 'scanned_at')) {
            $scannedTickets = Ticket::whereNotNull('scanned_at')->count();
            $todayScans     = Ticket::whereNotNull('scanned_at')
                                    ->whereDate('scanned_at', today())
                                    ->count();
        } else {
            $scannedTickets = Ticket::where('status', 'used')->count();
            $todayScans     = Ticket::where('status', 'used')
                                    ->whereDate('updated_at', today())
                                    ->count();
        }

        $pendingTickets      = max(0, $totalTickets - $scannedTickets);
        $claimedParticipants = Ticket::distinct('user_id')->count(); // peserta unik yang klaim

        // hitung 'acara' jika modelnya ada (opsional)
        $acaraCount = null;
        if (class_exists(\App\Models\Acara::class)) {
            $acaraCount = \App\Models\Acara::count();
        }

        // statistik lain
        $stats = [
            'peserta'            => User::where('role', 'user')->count(),
            'petugas'            => User::where('role', 'petugas')->count(),
            'tiket'              => $totalTickets,
            'terscan'            => $scannedTickets,
            'pending'            => $pendingTickets,
            'peserta_klaim'      => $claimedParticipants,
            'acara'              => $acaraCount,       // null jika model tidak ada
            'today_scans'        => $todayScans,
        ];

        // tiket user sendiri (kalau role user)
        $myTicket = null;
        if ($role === 'user') {
            $myTicket = Ticket::with('user')
                ->where('user_id', $user->id)
                ->latest('created_at')
                ->first();
        }

        // daftar scan terbaru (untuk admin/petugas)
        $latestScans = collect();
        if (in_array($role, ['petugas', 'admin'])) {
            $latestScans = Ticket::with(['user', 'scannedBy'])
                ->when(Schema::hasColumn('tickets', 'scanned_at'),
                    fn ($q) => $q->whereNotNull('scanned_at'),
                    fn ($q) => $q->where('status', 'used')
                )
                ->latest(Schema::hasColumn('tickets', 'scanned_at') ? 'scanned_at' : 'updated_at')
                ->limit(8)
                ->get();
        }

        return view('dashboard.index', [
            'role'               => $role,
            'stats'              => $stats,
            'myTicket'           => $myTicket,
            'latestScans'        => $latestScans,

            // alias untuk view lama:
            'scannedTickets'     => $scannedTickets,
            'totalTickets'       => $totalTickets,
            'claimedParticipants'=> $claimedParticipants,
            'pendingTickets'     => $pendingTickets,
            'todayScans'         => $todayScans,
        ]);
    }
}
