<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('tickets', 'scanned_at')) {
                $table->timestamp('scanned_at')->nullable()->index()->after('status');
            }
            if (!Schema::hasColumn('tickets', 'scanned_by')) {
                // kalau FK bermasalah di env-mu, ganti ke unsignedBigInteger + ->nullable()->index() saja
                $table->foreignId('scanned_by')->nullable()
                    ->constrained('users')->nullOnDelete()->after('scanned_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'scanned_by')) {
                $table->dropConstrainedForeignId('scanned_by'); // drop FK + kolom
            }
            if (Schema::hasColumn('tickets', 'scanned_at')) {
                $table->dropColumn('scanned_at');
            }
        });
    }
};
