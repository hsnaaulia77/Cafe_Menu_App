<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->string('nama')->after('id');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 10, 2)->default(0);
            $table->enum('kategori', ['Makanan', 'Minuman', 'Camilan'])->default('Makanan');
            $table->string('gambar')->nullable();
            $table->enum('status', ['Tersedia', 'Tidak tersedia'])->default('Tersedia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['nama', 'deskripsi', 'harga', 'kategori', 'gambar', 'status']);
        });
    }
};
