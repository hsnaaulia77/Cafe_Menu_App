<?php

namespace App\Exports;

use App\Models\Menu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MenusExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Menu::select('nama', 'deskripsi', 'harga', 'kategori', 'status')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama Menu',
            'Deskripsi',
            'Harga',
            'Kategori',
            'Status',
        ];
    }
} 