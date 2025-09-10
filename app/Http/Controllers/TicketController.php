<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Picqer\Barcode\BarcodeGeneratorPNG;

class TicketController extends Controller
{
    public function showForm()
    {
        // kalau user sudah punya tiket, lempar ke halaman tiket
        if (Ticket::where('user_id', auth()->id())->exists()) {
            return redirect()
                ->route('ticket.show')
                ->with('err', 'Anda sudah melakukan klaim tiket. Setiap pengguna hanya boleh 1 tiket.');
        }

        return view('ticket.form');
    }

    public function claimTicket(Request $request)
    {
        // guard: stop kalau sudah punya tiket
        if (Ticket::where('user_id', auth()->id())->exists()) {
            return back()
                ->withErrors(['npm' => 'Anda sudah memiliki tiket. Setiap pengguna hanya boleh 1 tiket.'])
                ->withInput();
        }

        // validasi (NPM unik & bukti SIAK wajib)
        $data = $request->validate(
            [
                'npm'        => 'required|string|max:20|unique:tickets,npm',
                'bukti_npm'  => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:4096',
            ],
            [
                'npm.unique'         => 'NPM tersebut sudah pernah digunakan untuk klaim tiket.',
                'bukti_npm.required' => 'SS SIAK wajib diunggah.',
            ]
        );

        // simpan file bukti
        if (!Storage::disk('public')->exists('bukti_npm')) {
            Storage::disk('public')->makeDirectory('bukti_npm');
        }
        $path = $request->file('bukti_npm')->store('bukti_npm', 'public');

        // buat tiket
        $code = strtoupper('TKT-'.uniqid());
        $ticket = Ticket::create([
            'code'           => $code,
            'user_id'        => auth()->id(),
            'npm'            => $data['npm'],
            'status'         => 'new',
            'claimed_at'     => now(),
            'npm_proof_path' => $path,
        ]);


        // Generate Barcode dan QR Code
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($ticket->code, $generator::TYPE_CODE_128);
        $barcodePath = public_path('barcodes/'.$ticket->code.'_barcode.png');
        file_put_contents($barcodePath, $barcode);

        $qrCode = QrCode::size(100)->generate($ticket->code);
        $qrCodePath = public_path('qrcodes/'.$ticket->code.'_qrcode.png');
        file_put_contents($qrCodePath, $qrCode);

        // Simpan path Barcode dan QR Code ke tiket
        $ticket->barcode_path = 'barcodes/'.$ticket->code.'_barcode.png';
        $ticket->qrcode_path = 'qrcodes/'.$ticket->code.'_qrcode.png';
        $ticket->save();

        return redirect()
            ->route('ticket.show')
            ->with('ok', "Tiket berhasil dibuat dengan kode: {$ticket->code}");
    }

    public function showTicket()
    {
        $tickets = Ticket::where('user_id', auth()->id())->get();
        return view('ticket.show', compact('tickets'));
    }
}