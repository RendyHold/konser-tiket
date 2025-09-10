<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Picqer\Barcode\BarcodeGeneratorPNG;
=======
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
>>>>>>> parent of d2bcd1e (a)

class TicketController extends Controller
{
    public function claimTicket(Request $request)
    {
        // Guard: stop kalau sudah punya tiket
        if (auth()->user()->tickets()->exists()) {
            return back()
                ->withErrors(['npm' => 'Anda sudah memiliki tiket. Setiap pengguna hanya boleh 1 tiket.'])
                ->withInput();
        }

        // Validasi (NPM unik & bukti SIAK wajib)
        $data = $request->validate(
            [
                'npm'        => 'required|string|max:20|unique:tickets,npm',
                'bukti_npm'  => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:4096',
            ]
        );

        // Simpan file bukti
        $path = $request->file('bukti_npm')->store('bukti_npm', 'public');

        // Buat tiket
        $code = strtoupper('TKT-'.uniqid());

        // Pastikan folder 'barcodes' ada (hanya jika menggunakan penyimpanan fisik)
        // Optional: Hapus bagian ini jika tidak menggunakan disk

        // Generate Barcode
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($code, $generator::TYPE_CODE_128);

        // Generate QR Code
        $qrCode = QrCode::size(100)->generate($code);

        // Gabungkan Barcode dan QR Code dengan Gambar Tiket
        $ticketImage = imagecreatefrompng(public_path('img/tiket.png')); // Gambar tiket awal
        $barcodeImage = imagecreatefromstring($barcode); // Barcode image
        $qrCodeImage = imagecreatefromstring($qrCode); // QR Code image

        // Tentukan posisi QR Code dalam gambar tiket (di kiri kotak kosong)
        $barcodeWidth = imagesx($barcodeImage);
        $barcodeHeight = imagesy($barcodeImage);
        $qrWidth = imagesx($qrCodeImage);
        $qrHeight = imagesy($qrCodeImage);

        // Menempatkan barcode dan QR code ke gambar tiket
        $barcodeX = 30;  // Posisi X untuk barcode
        $barcodeY = 200; // Posisi Y untuk barcode
        imagecopy($ticketImage, $barcodeImage, $barcodeX, $barcodeY, 0, 0, $barcodeWidth, $barcodeHeight);

        $qrX = 30;  // Posisi X untuk QR code di kotak kiri
        $qrY = 50;  // Posisi Y untuk QR code
        imagecopy($ticketImage, $qrCodeImage, $qrX, $qrY, 0, 0, $qrWidth, $qrHeight);

        // Tampilkan gambar tiket dengan barcode dan QR code langsung tanpa menyimpan
        return response()->stream(function () use ($ticketImage) {
            imagepng($ticketImage); // Tampilkan gambar langsung di browser
        }, 200, [
            'Content-Type' => 'image/png',
        ]);

<<<<<<< HEAD
        // Hapus gambar yang sudah tidak digunakan
        imagedestroy($ticketImage);
        imagedestroy($barcodeImage);
        imagedestroy($qrCodeImage);
=======
        return redirect()
            ->route('ticket.show')
            ->with('ok', "Tiket berhasil dibuat dengan kode: {$ticket->code}");
>>>>>>> parent of d2bcd1e (a)
    }

    public function showTicket()
    {
            // Mengambil data tiket berdasarkan user yang login
    $tickets = Ticket::where('user_id', auth()->id())->get(); // Ambil data tiket

    // Kirim data tiket ke view
    return view('ticket.show', ['tickets' => $tickets]);
    }

    public function showForm()
    {
        // Logika untuk menampilkan form tiket
        return view('ticket.form');
    }

    public function showTicketWithQRCode($ticketCode)
    {
        // Gabungkan Barcode dan QR Code dengan Gambar Tiket
        $ticketImage = imagecreatefrompng(public_path('img/tiket.png'));

        // Generate QR Code
        $qrCode = QrCode::size(100)->generate($ticketCode);
        $qrCodeImage = imagecreatefromstring($qrCode);

        // Tentukan posisi QR Code di gambar tiket
        $qrWidth = imagesx($qrCodeImage);
        $qrHeight = imagesy($qrCodeImage);

        // Tentukan posisi QR Code di gambar tiket
        $qrX = 20;
        $qrY = 100;

        // Menempatkan QR code ke gambar tiket
        imagecopy($ticketImage, $qrCodeImage, $qrX, $qrY, 0, 0, $qrWidth, $qrHeight);

        // Return image to browser as response without saving
        return response()->stream(function () use ($ticketImage) {
            imagepng($ticketImage); // Direct output image
        }, 200, [
            'Content-Type' => 'image/png',
        ]);
    }
}
