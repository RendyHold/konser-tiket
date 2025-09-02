<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('acaras', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->dateTime('tanggal');
            $table->string('lokasi')->nullable();
            $table->unsignedInteger('kuota')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('acaras'); }
};
