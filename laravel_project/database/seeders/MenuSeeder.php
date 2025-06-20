<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'nama' => 'Espresso',
                'deskripsi' => 'Strong coffee served in a small cup',
                'harga' => 3500,
                'kategori' => 'Makanan',
                'status' => 'Tersedia',
                'gambar' => null
            ],
            [
                'nama' => 'Cappuccino',
                'deskripsi' => 'Espresso with steamed milk and foam',
                'harga' => 4500,
                'kategori' => 'Makanan',
                'status' => 'Tersedia',
                'gambar' => null
            ],
            [
                'nama' => 'Latte',
                'deskripsi' => 'Espresso with steamed milk',
                'harga' => 4000,
                'kategori' => 'Makanan',
                'status' => 'Tersedia',
                'gambar' => null
            ],
            [
                'nama' => 'Iced Coffee',
                'deskripsi' => 'Chilled coffee served with ice',
                'harga' => 4000,
                'kategori' => 'Makanan',
                'status' => 'Tersedia',
                'gambar' => null
            ],
            [
                'nama' => 'Croissant',
                'deskripsi' => 'Buttery, flaky pastry',
                'harga' => 3000,
                'kategori' => 'Makanan',
                'status' => 'Tersedia',
                'gambar' => null
            ]
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
