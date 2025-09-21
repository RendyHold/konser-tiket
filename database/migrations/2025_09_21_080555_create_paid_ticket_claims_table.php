<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paid_ticket_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('npm')->index();
            $table->unsignedInteger('amount')->default(0);          // nominal yang dibayar
            $table->string('npm_proof_path');                       // bukti NPM upload
            $table->string('payment_proof_path');                   // bukti bayar upload
            $table->enum('status', ['pending','approved','rejected','issued'])
                  ->default('pending')->index();
            $table->string('reject_reason')->nullable();
            $table->timestamp('approved_at')->nullable();

            // hasil akhir (tiket setelah di-approve admin)
            $table->string('ticket_code')->nullable();
            $table->string('final_ticket_path')->nullable();
            $table->string('qrcode_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paid_ticket_claims');
    }
};
