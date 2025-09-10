<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;

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

        return redirect()
            ->route('ticket.show')
            ->with('ok', "Tiket berhasil dibuat dengan kode: {$ticket->code}");
    }

    private function generateTicketImages(Ticket $ticket)
{
    // Pastikan folder 'barcodes' ada
    $barcodePath = base_path('app/data/barcodes');
    if (!file_exists($barcodePath)) {
        mkdir($barcodePath, 0755, true);
    }

    // Generate Barcode
    $generator = new BarcodeGeneratorPNG();
    $barcode = $generator->getBarcode($ticket->code, $generator::TYPE_CODE_128);
    $barcodeFilePath = $barcodePath.'/'.$ticket->code.'_barcode.png';
    file_put_contents($barcodeFilePath, $barcode);

    // Generate QR Code
    $qrCode = QrCode::size(100)->generate($ticket->code);
    $qrCodePath = base_path('app/data/qrcodes/'.$ticket->code.'_qrcode.png');
    file_put_contents($qrCodePath, $qrCode);

    // Gabungkan Barcode dan QR Code dengan Gambar Tiket
    $ticketImage = imagecreatefrompng(base_path('img/tiket.png')); // Gambar tiket awal
    $barcodeImage = imagecreatefromstring($barcode); // Gambar barcode
    $qrCodeImage = imagecreatefromstring($qrCode); // Gambar QR Code

    // Tentukan posisi QR Code dan Barcode di gambar tiket
    $barcodeWidth = imagesx($barcodeImage);
    $barcodeHeight = imagesy($barcodeImage);
    $qrWidth = imagesx($qrCodeImage);
    $qrHeight = imagesy($qrCodeImage);

    // Menempatkan barcode dan QR code ke gambar tiket
    $barcodeX = 30;  // Posisi X untuk barcode
    $barcodeY = 200; // Posisi Y untuk barcode
    imagecopy($ticketImage, $barcodeImage, $barcodeX, $barcodeY, 0, 0, $barcodeWidth, $barcodeHeight);

    // Menempatkan QR Code di kiri atas tiket
    $qrX = 30;  // Posisi X untuk QR code di kiri
    $qrY = 30;  // Posisi Y untuk QR code di atas
    imagecopy($ticketImage, $qrCodeImage, $qrX, $qrY, 0, 0, $qrWidth, $qrHeight);

    // Simpan gambar tiket dengan barcode dan QR code
    $finalTicketPath = base_path('app/data/barcodes/'.$ticket->code.'_with_qr_ticket.png');
    imagepng($ticketImage, $finalTicketPath);

    // Hapus gambar yang sudah tidak digunakan
    imagedestroy($ticketImage);
    imagedestroy($barcodeImage);
    imagedestroy($qrCodeImage);

    // Simpan path gambar tiket ke database (optional)
    $ticket->barcode_path = 'app/data/barcodes/'.$ticket->code.'_with_qr_ticket.png';
    $ticket->qrcode_path = 'app/data/qrcodes/'.$ticket->code.'_qrcode.png';
    $ticket->save();
}


    public function showTicket()
    {
        $tickets = Ticket::where('user_id', auth()->id())->get();
        return view('ticket.show', compact('tickets'));
    }
}