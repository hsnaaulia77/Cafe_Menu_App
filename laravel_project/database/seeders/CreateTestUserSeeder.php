<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateTestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create customer user
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Create kasir user
        User::create([
            'name' => 'Kasir User',
            'email' => 'kasir@example.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        // Create barista user
        User::create([
            'name' => 'Barista User',
            'email' => 'barista@example.com',
            'password' => Hash::make('password'),
            'role' => 'barista',
        ]);

        $this->command->info('Test users created successfully!');
        $this->command->info('Admin: admin@example.com / password');
        $this->command->info('Customer: customer@example.com / password');
        $this->command->info('Kasir: kasir@example.com / password');
        $this->command->info('Barista: barista@example.com / password');
    }
}
