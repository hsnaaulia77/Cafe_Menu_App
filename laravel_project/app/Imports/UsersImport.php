<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Cek jika user sudah ada berdasarkan email
        $user = User::where('email', $row['email'])->first();
        $data = [
            'name' => $row['nama'],
            'email' => $row['email'],
            'role' => $row['role'] ?? 'customer',
            'status' => $row['status'] ?? 'aktif',
        ];
        if (!empty($row['password'])) {
            $data['password'] = Hash::make($row['password']);
        }
        if ($user) {
            $user->update($data);
            return null;
        } else {
            if (empty($data['password'])) {
                $data['password'] = Hash::make('password123'); // default password
            }
            return new User($data);
        }
    }
} 