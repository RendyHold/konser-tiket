<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('tickets')) return;

        // 1) status
        if (! Schema::hasColumn('tickets', 'status')) {
            Schema::table('tickets', function (Blueprint $table) {
                // string lebih fleksibel dari enum
                $col = $table->string('status', 32)->default('unused')->index();
                // taruh setelah user_id hanya jika kolomnya ada
                if (Schema::hasColumn('tickets', 'user_id')) {
                    $col->after('user_id');
                }
            });
        }

        // 2) scan fields
        if (! Schema::hasColumn('tickets', 'scanned_at')) {
            Schema::table('tickets', function (Blueprint $table) {
                $col = $table->timestamp('scanned_at')->nullable()->index();
                // aman kalau 'status' belum ada
                if (Schema::hasColumn('tickets', 'status')) {
                    $col->after('status');
                }
            });
        }

        if (! Schema::hasColumn('tickets', 'scanned_by')) {
            Schema::table('tickets', function (Blueprint $table) {
                // buat kolomnya dulu
                $col = $table->unsignedBigInteger('scanned_by')->nullable()->index();
                if (Schema::hasColumn('tickets', 'scanned_at')) {
                    $col->after('scanned_at');
                }
            });

            // pasang FK hanya jika tabel users ada (dan biasanya sudah ada)
            if (Schema::hasTable('users')) {
                Schema::table('tickets', function (Blueprint $table) {
                    try {
                        $table->foreign('scanned_by')
                              ->references('id')->on('users')
                              ->nullOnDelete();
                    } catch (\Throwable $e) {
                        // kalau gagal FK (engine/collation), biarkan kolom tanpa FK
                    }
                });
            }
        }

        // 3) bukti NPM
        if (! Schema::hasColumn('tickets', 'npm_proof_path')) {
            Schema::table('tickets', function (Blueprint $table) {
                // 512 cukup untuk relative path; pakai ->text() jika perlu sangat panjang
                $col = $table->string('npm_proof_path', 512)->nullable();
                if (Schema::hasColumn('tickets', 'npm')) {
                    $col->after('npm');
                }
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('tickets')) return;

        // npm_proof_path
        if (Schema::hasColumn('tickets', 'npm_proof_path')) {
            Schema::table('tickets', fn (Blueprint $t) => $t->dropColumn('npm_proof_path'));
        }

        // scanned_by (lepas FK kalau ada)
        if (Schema::hasColumn('tickets', 'scanned_by')) {
            Schema::table('tickets', function (Blueprint $t) {
                try { $t->dropForeign(['scanned_by']); } catch (\Throwable $e) {}
                $t->dropColumn('scanned_by');
            });
        }

        // scanned_at
        if (Schema::hasColumn('tickets', 'scanned_at')) {
            Schema::table('tickets', fn (Blueprint $t) => $t->dropColumn('scanned_at'));
        }

        // status (drop index dulu kalau ada)
        if (Schema::hasColumn('tickets', 'status')) {
            Schema::table('tickets', function (Blueprint $t) {
                try { $t->dropIndex(['status']); } catch (\Throwable $e) {}
                $t->dropColumn('status');
            });
        }
    }
};
