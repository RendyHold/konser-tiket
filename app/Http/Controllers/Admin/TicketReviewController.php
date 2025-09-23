<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TicketReviewController extends Controller
{
    public function index() {
        $tickets = Ticket::latest()->paginate(20);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket) {
        return view('admin.tickets.show', compact('ticket'));
    }

    public function approve(Request $request, Ticket $ticket) {
        abort_unless(Gate::allows('admin'), 403);

        if ($ticket->status !== 'pending' && $ticket->status !== 'approved') {
            return back()->with('err','Status tidak bisa di-approve.');
        }

        // Ubah ke approved
        $ticket->status = 'approved';
        $ticket->approved_at = now();
        $ticket->save();

        // Generate tiket final -> set status issued
        app(\App\Services\TicketImageService::class)->generate($ticket); // lihat bagian 7
        $ticket->status = 'issued';
        $ticket->save();

        return redirect()->route('admin.tickets.show',$ticket)->with('ok','Tiket disetujui & digenerate.');
    }

    public function reject(Request $request, Ticket $ticket) {
        abort_unless(Gate::allows('admin'), 403);

        $data = $request->validate(['reason'=>'required|string|max:255']);
        $ticket->status = 'rejected';
        $ticket->reject_reason = $data['reason'];
        $ticket->save();

        return redirect()->route('admin.tickets.show',$ticket)->with('ok','Tiket ditolak.');
    }
}
