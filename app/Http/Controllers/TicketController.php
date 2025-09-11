<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    // Menampilkan form klaim tiket
    public function showForm()
    {
        // Jika user sudah punya tiket, arahkan ke halaman tiket
        if (Ticket::where('user_id', auth()->id())->exists()) {
            return redirect()
                ->route('ticket.show')
                ->with('err', 'Anda sudah melakukan klaim tiket. Setiap pengguna hanya boleh 1 tiket.');
        }

        return view('ticket.form');
    }

    // Klaim tiket baru
    public function claimTicket(Request $request)
    {
        // Guard: stop jika sudah punya tiket
        if (Ticket::where('user_id', auth()->id())->exists()) {
            return back()
                ->withErrors(['npm' => 'Anda sudah memiliki tiket. Setiap pengguna hanya boleh 1 tiket.'])
                ->withInput();
        }

        // Validasi input
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

        // Simpan file bukti
        $path = $request->file('bukti_npm')->store('bukti_npm', 'public');

        // Buat tiket baru
        $code = strtoupper('TKT-'.uniqid());
        $ticket = Ticket::create([
            'code'           => $code,
            'user_id'        => auth()->id(),
            'npm'            => $data['npm'],
            'status'         => 'new',
            'claimed_at'     => now(),
            'npm_proof_path' => $path,
        ]);

        // Generate barcode dan QR code dan simpan ke folder public
        $this->generateTicketImages($ticket);

        return redirect()
            ->route('ticket.show')
            ->with('ok', "Tiket berhasil dibuat dengan kode: {$ticket->code}");
    }

    // Fungsi untuk menggabungkan QR Code dan Barcode dengan Gambar Tiket

    public function generateTicketImages(Ticket $ticket)
    {
    // Pastikan folder 'barcodes' ada
    $barcodePath = base_path('data/barcodes');
    if (!file_exists($barcodePath)) {
        mkdir($barcodePath, 0755, true);
    }

    // Pastikan folder 'barcodes' ada
    $barcodePath = base_path('data/barcodes');
    if (!file_exists($barcodePath)) {
        mkdir($barcodePath, 0755, true);
    }

    // Generate Barcode
    $generator = new BarcodeGeneratorPNG();
    $barcode = $generator->getBarcode($ticket->code, $generator::TYPE_CODE_128);
    $barcodeFilePath = $barcodePath.'/'.$ticket->code.'_barcode.png';
    file_put_contents($barcodeFilePath, $barcode);

    // Generate QR Code
    $qrCodePath = base_path('data/qrcodes/'.$ticket->code.'_qrcode.png');
    QrCode::format('png')->size(200)->generate($ticket->code, $qrCodePath); // Pastikan QR code disimpan sebagai PNG

    // Gabungkan Barcode dan QR Code dengan Gambar Tiket
    $ticketImage = imagecreatefrompng(public_path('image/tiket.png')); // Gambar tiket awal
    $barcodeImage = imagecreatefrompng($barcodeFilePath); // Gambar barcode
    $qrCodeImage = imagecreatefrompng($qrCodePath); // Gambar QR Code

    // Tentukan posisi QR Code dan Barcode di gambar tiket
    $barcodeWidth = imagesx($barcodeImage);
    $barcodeHeight = imagesy($barcodeImage);
    $qrWidth = imagesx($qrCodeImage);
    $qrHeight = imagesy($qrCodeImage);

    // Menempatkan barcode dan QR code ke gambar tiket
    $barcodeX = 100;  // Posisi X untuk barcode
    $barcodeY = $qrY + $qrHeight + 20; // Posisi Y untuk barcode
    imagecopy($ticketImage, $barcodeImage, $barcodeX, $barcodeY, 0, 0, $barcodeWidth, $barcodeHeight);

    // Menempatkan QR Code di kiri atas tiket
    $qrX = 100;  // Posisi X untuk QR code di kiri
    $qrY = 50;  // Posisi Y untuk QR code di atas
    imagecopy($ticketImage, $qrCodeImage, $qrX, $qrY, 0, 0, $qrWidth, $qrHeight);

    // Simpan gambar tiket dengan barcode dan QR code
    $finalTicketPath = base_path('data/barcodes/'.$ticket->code.'_with_qr_ticket.png');
    imagepng($ticketImage, $finalTicketPath);

    // Hapus gambar yang sudah tidak digunakan
    imagedestroy($ticketImage);
    imagedestroy($barcodeImage);
    imagedestroy($qrCodeImage);

    // Simpan path gambar tiket ke database (optional)
    $ticket->barcode_path = 'data/barcodes/'.$ticket->code.'_with_qr_ticket.png';
    $ticket->qrcode_path = 'data/qrcodes/'.$ticket->code.'_qrcode.png';
    $ticket->save();
    }

    // Menampilkan tiket
    public function showTicket()
    {
        $tickets = Ticket::where('user_id', auth()->id())->get();
        return view('ticket.show', compact('tickets'));
    }
}
