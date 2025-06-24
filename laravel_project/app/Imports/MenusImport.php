<?php

namespace App\Imports;

use App\Models\Menu;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MenusImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Menu([
            'nama'      => $row['nama_menu'],
            'deskripsi' => $row['deskripsi'],
            'harga'     => $row['harga'],
            'kategori'  => $row['kategori'],
            'status'    => $row['status'] ?? 'active',
            'gambar'    => 'images/default-menu.png', // Default image
        ]);
    }
} 