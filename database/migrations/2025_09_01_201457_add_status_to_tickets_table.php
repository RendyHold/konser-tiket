<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('tickets') && ! Schema::hasColumn('tickets', 'status')) {
            Schema::table('tickets', function (Blueprint $table) {
                // batasi panjang secukupnya
                $column = $table->string('status', 32)->default('new')->index();

                // tempatkan setelah 'npm' hanya jika kolom 'npm' ada
                if (Schema::hasColumn('tickets', 'npm')) {
                    $column->after('npm');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tickets') && Schema::hasColumn('tickets', 'status')) {
            Schema::table('tickets', function (Blueprint $table) {
                // drop index jika ada (opsional, MySQL biasanya otomatis)
                try { $table->dropIndex(['status']); } catch (\Throwable $e) {}
                $table->dropColumn('status');
            });
        }
    }
};
