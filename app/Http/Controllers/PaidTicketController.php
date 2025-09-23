<?php
// app/Http/Controllers/PaidTicketController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Ticket;
use Illuminate\Support\Str;

class PaidTicketController extends Controller
{
    public function showForm()
    {
        // Jika user sudah punya paid (pending/approved/issued), arahkan ke list
        $exists = Ticket::where('user_id', auth()->id())
            ->where('ticket_type', 'paid')
            ->whereIn('status', ['pending','approved','issued'])
            ->exists();

        if ($exists) {
            return redirect()->route('ticket.show')->with('err', 'Kamu sudah klaim tiket berbayar.');
        }

        return view('ticket.form_paid');
    }

    public function claim(Request $request)
    {
        $data = $request->validate([
            'npm'         => [
                'required','string','max:20',
                // unique khusus untuk baris 'paid' agar tidak bentrok dengan tiket gratis
                Rule::unique('tickets','npm')->where(fn($q) => $q->where('ticket_type','paid')),
            ],
            'bukti_npm'   => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:4096',
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:4096',
        ],[
            'npm.unique' => 'NPM ini sudah digunakan untuk tiket berbayar.',
        ]);

        $npmProofPath     = $request->file('bukti_npm')->store('bukti_npm','public');
        $paymentProofPath = $request->file('bukti_bayar')->store('bukti_bayar','public');

        $code    = strtoupper('TKT-'.Str::upper(Str::random(10)));
        $invoice = 'INV-'.now()->format('ymd').'-'.Str::upper(Str::random(6));

        Ticket::create([
            'code'               => $code,
            'invoice_no'         => $invoice,
            'user_id'            => auth()->id(),
            'npm'                => $data['npm'],
            'ticket_type'        => 'paid',
            'status'             => 'pending',  // menunggu verifikasi admin
            'price'              => 0,          // isi sesuai harga jika ada
            'npm_proof_path'     => $npmProofPath,
            'payment_proof_path' => $paymentProofPath,
        ]);

        return redirect()->route('ticket.show')->with('ok', 'Klaim berbayar terkirim. Menunggu verifikasi admin.');
    }
}
