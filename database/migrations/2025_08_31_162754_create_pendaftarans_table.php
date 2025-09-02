<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tiket', 32)->unique();
            $table->foreignId('acara_id')->constrained('acaras')->cascadeOnDelete();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->boolean('scanned')->default(false);
            $table->timestamp('scanned_at')->nullable();
            $table->timestamps();
            $table->unique(['acara_id','mahasiswa_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('pendaftarans'); }
};
