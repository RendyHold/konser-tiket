<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // pastikan belum ada index unik dengan nama sama
            // dan data existing tidak duplikat (kalau ada, bereskan dulu baru migrate)
            $table->unique('user_id', 'tickets_user_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropUnique('tickets_user_id_unique');
        });
    }
};
