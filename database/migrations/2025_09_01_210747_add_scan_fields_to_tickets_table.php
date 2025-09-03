<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('tickets')) {
            return;
        }

        Schema::table('tickets', function (Blueprint $table) {
            // scanned_at
            if (! Schema::hasColumn('tickets', 'scanned_at')) {
                $col = $table->timestamp('scanned_at')->nullable()->index();
                if (Schema::hasColumn('tickets', 'status')) {
                    $col->after('status');
                }
            }

            // scanned_by
            if (! Schema::hasColumn('tickets', 'scanned_by')) {
                // kalau FK sering gagal di hostingmu, ganti 3 baris di bawah
                // dengan: $table->unsignedBigInteger('scanned_by')->nullable()->index();
                $col = $table->foreignId('scanned_by')->nullable();
                if (Schema::hasColumn('tickets', 'scanned_at')) {
                    $col->after('scanned_at');
                }
                if (Schema::hasTable('users')) {
                    $table->foreign('scanned_by')
                          ->references('id')->on('users')
                          ->nullOnDelete();
                }
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('tickets')) {
            return;
        }

        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'scanned_by')) {
                // aman untuk kasus constraint ada/tidak ada
                try { $table->dropForeign(['scanned_by']); } catch (\Throwable $e) {}
                $table->dropColumn('scanned_by');
            }

            if (Schema::hasColumn('tickets', 'scanned_at')) {
                $table->dropColumn('scanned_at');
            }
        });
    }
};
