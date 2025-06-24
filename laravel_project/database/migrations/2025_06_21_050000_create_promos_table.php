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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->enum('jenis', ['diskon_persen', 'diskon_nominal', 'voucher', 'bundle']);
            $table->decimal('nilai', 10, 2); // Nilai diskon atau voucher
            $table->string('kode_kupon')->unique()->nullable(); // Untuk voucher
            $table->decimal('minimum_pembelian', 10, 2)->default(0); // Minimum pembelian untuk menggunakan promo
            $table->integer('maksimal_penggunaan')->nullable(); // Maksimal berapa kali bisa digunakan
            $table->integer('sudah_digunakan')->default(0); // Sudah berapa kali digunakan
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->json('menu_bundle')->nullable(); // Untuk promo bundle, berisi array menu_id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
}; 