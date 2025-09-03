<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('tickets') || Schema::hasColumn('tickets', 'npm_proof_path')) {
            return;
        }

        Schema::table('tickets', function (Blueprint $table) {
            // pakai 512 agar aman terhadap batas ukuran row;
            // kalau butuh lebih panjang, ganti ke ->text() saja.
            $col = $table->string('npm_proof_path', 512)->nullable();

            if (Schema::hasColumn('tickets', 'npm')) {
                $col->after('npm');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('tickets') || ! Schema::hasColumn('tickets', 'npm_proof_path')) {
            return;
        }

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('npm_proof_path');
        });
    }
};
