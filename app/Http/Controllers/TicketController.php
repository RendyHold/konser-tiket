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
            // Pastikan folder 'qrcodes' ada
    $qrCodePath = base_path('data/qrcodes');
    if (!file_exists($qrCodePath)) {
        mkdir($qrCodePath, 0755, true);
    }

    // Generate QR Code
    $qrCode = QrCode::size(150)->generate($ticket->code); // Ukuran QR bisa disesuaikan
    $qrCodePath = $qrCodePath.'/'.$ticket->code.'_qrcode.png';
    file_put_contents($qrCodePath, $qrCode);

    // Gabungkan QR Code dengan Gambar Tiket
    $ticketImage = imagecreatefrompng(public_path('img/tiket.png')); // Gambar tiket awal
    $qrCodeImage = imagecreatefromstring($qrCode); // Gambar QR Code

    // Tentukan posisi QR Code di kotak pada gambar tiket
    $qrWidth = imagesx($qrCodeImage);
    $qrHeight = imagesy($qrCodeImage);

    // Menempatkan QR Code di kotak (misalnya di posisi kiri atas)
    $qrX = 40;  // Posisi X untuk QR code di dalam kotak
    $qrY = 50;  // Posisi Y untuk QR code di dalam kotak
    imagecopy($ticketImage, $qrCodeImage, $qrX, $qrY, 0, 0, $qrWidth, $qrHeight);

    // Simpan gambar tiket dengan QR code
    $finalTicketPath = public_path('data/tickets/'.$ticket->code.'_with_qr_ticket.png');
    imagepng($ticketImage, $finalTicketPath);

    // Hapus gambar yang sudah tidak digunakan
    imagedestroy($ticketImage);
    imagedestroy($qrCodeImage);

    // Simpan path gambar tiket ke database (optional)
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
