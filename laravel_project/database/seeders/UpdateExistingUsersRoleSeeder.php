<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateExistingUsersRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update all existing users to have 'admin' role if they don't have one
        User::whereNull('role')->orWhere('role', '')->update(['role' => 'admin']);
        
        $this->command->info('Updated existing users with admin role.');
    }
}
