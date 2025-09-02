<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Acara;

class AcaraSeeder extends Seeder
{
    public function run(): void
    {
        Acara::firstOrCreate([
            'nama'    => 'Konser Kampus 2025',
            'tanggal' => now()->addDays(7),
            'lokasi'  => 'Aula Utama',
            'kuota'   => 1000,
        ]);
    }
}
