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
                'name' => 'Espresso',
                'description' => 'Strong coffee served in a small cup',
                'price' => 3.50,
                'category' => 'Hot Coffee',
                'is_available' => true
            ],
            [
                'name' => 'Cappuccino',
                'description' => 'Espresso with steamed milk and foam',
                'price' => 4.50,
                'category' => 'Hot Coffee',
                'is_available' => true
            ],
            [
                'name' => 'Latte',
                'description' => 'Espresso with steamed milk',
                'price' => 4.00,
                'category' => 'Hot Coffee',
                'is_available' => true
            ],
            [
                'name' => 'Iced Coffee',
                'description' => 'Chilled coffee served with ice',
                'price' => 4.00,
                'category' => 'Cold Coffee',
                'is_available' => true
            ],
            [
                'name' => 'Croissant',
                'description' => 'Buttery, flaky pastry',
                'price' => 3.00,
                'category' => 'Pastries',
                'is_available' => true
            ]
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
