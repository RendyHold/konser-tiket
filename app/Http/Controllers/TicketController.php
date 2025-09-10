<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Picqer\Barcode\BarcodeGeneratorPNG;

class TicketController extends Controller
{
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
        ]
    );

    // simpan file bukti
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

    // Pastikan folder 'barcodes' ada
    if (!Storage::disk('public')->exists('barcodes')) {
        Storage::disk('public')->makeDirectory('barcodes');
    }

    // Generate Barcode
    $generator = new BarcodeGeneratorPNG();
    $barcode = $generator->getBarcode($ticket->code, $generator::TYPE_CODE_128);
    $barcodePath = public_path('barcodes/'.$ticket->code.'_barcode.png');
    file_put_contents($barcodePath, $barcode);

    // Generate QR Code
    $qrCode = QrCode::size(100)->generate($ticket->code);
    $qrCodePath = public_path('qrcodes/'.$ticket->code.'_qrcode.png');
    file_put_contents($qrCodePath, $qrCode);

    // Gabungkan Barcode dan QR Code dengan Gambar Tiket
    $ticketImage = imagecreatefrompng(public_path('img/tiket.png')); // Gambar tiket awal
    $barcodeImage = imagecreatefromstring($barcode); // Barcode image
    $qrCodeImage = imagecreatefromstring($qrCode); // QR Code image

    // Tentukan posisi QR Code dalam gambar tiket
    $barcodeWidth = imagesx($barcodeImage);
    $barcodeHeight = imagesy($barcodeImage);
    $qrWidth = imagesx($qrCodeImage);
    $qrHeight = imagesy($qrCodeImage);

    // Menempatkan barcode dan QR code ke gambar tiket
    $barcodeX = 30;  // Posisi X untuk barcode
    $barcodeY = 200; // Posisi Y untuk barcode
    imagecopy($ticketImage, $barcodeImage, $barcodeX, $barcodeY, 0, 0, $barcodeWidth, $barcodeHeight);

    $qrX = 150;  // Posisi X untuk QR code
    $qrY = 220;  // Posisi Y untuk QR code
    imagecopy($ticketImage, $qrCodeImage, $qrX, $qrY, 0, 0, $qrWidth, $qrHeight);

    // Simpan gambar tiket dengan barcode dan QR code
    $finalTicketPath = public_path('barcodes/'.$ticket->code.'_with_qr_ticket.png');
    imagepng($ticketImage, $finalTicketPath);

    // Hapus gambar yang sudah tidak digunakan
    imagedestroy($ticketImage);
    imagedestroy($barcodeImage);
    imagedestroy($qrCodeImage);

    // Simpan path gambar tiket ke database
    $ticket->barcode_path = 'barcodes/'.$ticket->code.'_with_qr_ticket.png';
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

    public function showForm()
    {
    // Logika untuk menampilkan form tiket
    return view('ticket.form');
    }



}
