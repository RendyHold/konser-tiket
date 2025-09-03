<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // pastikan tabelnya ada
        if (! Schema::hasTable('tickets')) {
            return; // atau lempar exception kalau mau hard fail
        }

        // 1) status
        if (! Schema::hasColumn('tickets', 'status')) {
            Schema::table('tickets', function (Blueprint $table) {
                // pilih salah satu tipe; string lebih fleksibel dari enum
                $table->string('status', 32)
                      ->default('unused')
                      ->after('user_id')
                      ->index();
            });
        }

        // 2) scan fields
        if (! Schema::hasColumn('tickets', 'scanned_at')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->timestamp('scanned_at')->nullable()->after('status');
            });
        }

        if (! Schema::hasColumn('tickets', 'scanned_by')) {
            Schema::table('tickets', function (Blueprint $table) {
                // nullable supaya tidak gagal saat user tidak ada
                $table->foreignId('scanned_by')
                      ->nullable()
                      ->after('scanned_at')
                      ->constrained('users')
                      ->nullOnDelete();
            });
        }

        // 3) bukti NPM
        if (! Schema::hasColumn('tickets', 'npm_proof_path')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->string('npm_proof_path', 512)
                      ->nullable()
                      ->after('npm');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('tickets')) {
            return;
        }

        // drop dengan pengecekan supaya aman
        if (Schema::hasColumn('tickets', 'npm_proof_path')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->dropColumn('npm_proof_path');
            });
        }

        // lepas FK dulu jika ada
        if (Schema::hasColumn('tickets', 'scanned_by')) {
            Schema::table('tickets', function (Blueprint $table) {
                // nama constraint bisa berbeda; dropForeign guested by column:
                $table->dropForeign(['scanned_by']);
                $table->dropColumn('scanned_by');
            });
        }

        if (Schema::hasColumn('tickets', 'scanned_at')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->dropColumn('scanned_at');
            });
        }

        if (Schema::hasColumn('tickets', 'status')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->dropIndex(['status']);
                $table->dropColumn('status');
            });
        }
    }
};
