<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promo;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Diskon persentase
        Promo::create([
            'nama' => 'Diskon 20% Minuman',
            'deskripsi' => 'Dapatkan diskon 20% untuk semua minuman',
            'jenis' => 'diskon_persen',
            'nilai' => 20,
            'kode_kupon' => null,
            'minimum_pembelian' => 50000,
            'maksimal_penggunaan' => 100,
            'sudah_digunakan' => 15,
            'tanggal_mulai' => now(),
            'tanggal_berakhir' => now()->addMonths(3),
            'status' => 'aktif',
            'menu_bundle' => null,
        ]);

        // Diskon nominal
        Promo::create([
            'nama' => 'Potongan Rp 10.000',
            'deskripsi' => 'Potongan langsung Rp 10.000 untuk pembelian minimal Rp 100.000',
            'jenis' => 'diskon_nominal',
            'nilai' => 10000,
            'kode_kupon' => null,
            'minimum_pembelian' => 100000,
            'maksimal_penggunaan' => 50,
            'sudah_digunakan' => 8,
            'tanggal_mulai' => now(),
            'tanggal_berakhir' => now()->addMonths(2),
            'status' => 'aktif',
            'menu_bundle' => null,
        ]);

        // Voucher
        Promo::create([
            'nama' => 'Voucher HEMAT50',
            'deskripsi' => 'Voucher diskon 50% untuk pembelian pertama',
            'jenis' => 'voucher',
            'nilai' => 50,
            'kode_kupon' => 'HEMAT50',
            'minimum_pembelian' => 25000,
            'maksimal_penggunaan' => 200,
            'sudah_digunakan' => 45,
            'tanggal_mulai' => now(),
            'tanggal_berakhir' => now()->addMonths(6),
            'status' => 'aktif',
            'menu_bundle' => null,
        ]);

        // Bundle (akan diisi menu_bundle setelah menu tersedia)
        Promo::create([
            'nama' => 'Paket Sarapan Pagi',
            'deskripsi' => 'Paket sarapan dengan kopi dan roti',
            'jenis' => 'bundle',
            'nilai' => 25000,
            'kode_kupon' => null,
            'minimum_pembelian' => 0,
            'maksimal_penggunaan' => 30,
            'sudah_digunakan' => 5,
            'tanggal_mulai' => now(),
            'tanggal_berakhir' => now()->addMonths(1),
            'status' => 'aktif',
            'menu_bundle' => [1, 2], // Akan diisi dengan ID menu yang ada
        ]);

        $this->command->info('Sample promotions created successfully!');
    }
}
