<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Added missing import for DB facade

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite tidak mendukung ALTER ENUM, jadi harus workaround
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('status_tmp')->default('tersedia');
        });
        // Salin data lama ke kolom baru (mapping aktif->tersedia, tidak aktif->tidak tersedia)
        DB::table('menu_items')->update([
            'status_tmp' => DB::raw(
                
                    
                    "CASE status WHEN 'aktif' THEN 'tersedia' ELSE 'tidak tersedia' END"
                
            )
        ]);
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('menu_items', function (Blueprint $table) {
            $table->enum('status', ['tersedia', 'tidak tersedia'])->default('tersedia');
        });
        // Salin data kembali
        DB::table('menu_items')->update([
            'status' => DB::raw('status_tmp')
        ]);
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('status_tmp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke enum lama
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('status_tmp')->default('aktif');
        });
        DB::table('menu_items')->update([
            'status_tmp' => DB::raw(
                "CASE status WHEN 'tersedia' THEN 'aktif' ELSE 'tidak aktif' END"
            )
        ]);
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('menu_items', function (Blueprint $table) {
            $table->enum('status', ['aktif', 'tidak aktif'])->default('aktif');
        });
        DB::table('menu_items')->update([
            'status' => DB::raw('status_tmp')
        ]);
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('status_tmp');
        });
    }
};
