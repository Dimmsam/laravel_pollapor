<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom is_locked ke formulir_laporan untuk fitur Kunci Laporan.
     * Migration ini akan dijalankan di database Supabase PostgreSQL.
     */
    public function up(): void
    {
        // Cek apakah kolom sudah ada (karena tabel sudah ada di Supabase)
        if (! Schema::hasColumn('formulir_laporan', 'is_locked')) {
            Schema::table('formulir_laporan', function (Blueprint $table) {
                $table->boolean('is_locked')->default(false)->after('is_synced');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('formulir_laporan', 'is_locked')) {
            Schema::table('formulir_laporan', function (Blueprint $table) {
                $table->dropColumn('is_locked');
            });
        }
    }
};
