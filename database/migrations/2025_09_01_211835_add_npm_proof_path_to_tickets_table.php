<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('tickets', function (Blueprint $table) {
            // path file bukti (disimpan di storage)
            if (!Schema::hasColumn('tickets', 'npm_proof_path')) {
                $table->string('npm_proof_path', 2048)->nullable()->after('npm');
            }
        });
    }
    public function down(): void {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'npm_proof_path')) {
                $table->dropColumn('npm_proof_path');
            }
        });
    }
};
