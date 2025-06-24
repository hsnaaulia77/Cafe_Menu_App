<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateExistingUsersStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update all existing users to have 'aktif' status if they don't have one
        User::whereNull('status')->orWhere('status', '')->update(['status' => 'aktif']);
        
        $this->command->info('Updated existing users with active status.');
    }
}
