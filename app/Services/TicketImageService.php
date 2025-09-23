<?php

namespace App\Services;

use App\Models\Ticket;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketImageService
{
    public function generate(Ticket $ticket): void
    {
        // path output
        $dirBarcode = public_path('data/barcodes');
        $dirQrcode  = public_path('data/qrcodes');
        if (!is_dir($dirBarcode)) mkdir($dirBarcode,0755,true);
        if (!is_dir($dirQrcode))  mkdir($dirQrcode,0755,true);

        $qrPath = $dirQrcode.'/'.$ticket->code.'_qrcode.png';
        QrCode::format('png')->size(220)->margin(1)->generate($ticket->code, $qrPath);

        // Template tiket
        $ticketTemplatePath = public_path('image/tiket.png'); // pastikan ada
        $ticketImage = imagecreatefrompng($ticketTemplatePath);
        imagesavealpha($ticketImage,true);

        $qrImage = imagecreatefrompng($qrPath);

        // ukuran QR & posisi (sesuaikan koordinat biar pas)
        $qrW = imagesx($qrImage);
        $qrH = imagesy($qrImage);

        // contoh posisi QR (x=100, y=60)
        $qrX = 100;
        $qrY = 60;
        imagecopy($ticketImage, $qrImage, $qrX, $qrY, 0, 0, $qrW, $qrH);

        // Simpan tiket final
        $finalPath = $dirBarcode.'/'.$ticket->code.'_ticket.png';
        imagepng($ticketImage, $finalPath);

        imagedestroy($ticketImage);
        imagedestroy($qrImage);

        // Simpan path ke DB (relatif dari public)
        $ticket->qrcode_path  = 'data/qrcodes/'.$ticket->code.'_qrcode.png';
        $ticket->barcode_path = 'data/barcodes/'.$ticket->code.'_ticket.png';
        $ticket->save();
    }
}
