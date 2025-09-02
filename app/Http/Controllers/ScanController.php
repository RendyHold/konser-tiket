<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScanController extends Controller
{
    public function scanPage() { return view('ticket.scan'); }

    public function verifyScan(Request $request)
    {
        $data = $request->validate(['code' => 'required|string|max:255']);

        return DB::transaction(function () use ($data) {
            $ticket = Ticket::where('code', $data['code'])->lockForUpdate()->first();

            if (!$ticket) return response()->json(['ok'=>false,'message'=>'Kode tidak ditemukan.'],404);

            if ($ticket->scanned_at) {
                return response()->json(['ok'=>false,'message'=>'Tiket sudah dipakai pada '.$ticket->scanned_at->format('d M Y H:i')],409);
            }

            $ticket->scanned_at = now();
            $ticket->scanned_by = Auth::id();
            if ($ticket->isFillable('status')) $ticket->status = 'used';
            $ticket->save();

            return response()->json([
                'ok'=>true,
                'message'=>'Tiket valid. Akses diizinkan.',
                'ticket'=>[
                    'code'=>$ticket->code,
                    'owner'=>optional($ticket->user)->name,
                    'scanned_at'=>$ticket->scanned_at->toDateTimeString(),
                ]
            ]);
        });
    }
}