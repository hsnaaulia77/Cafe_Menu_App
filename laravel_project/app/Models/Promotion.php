<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'kode_voucher',
        'diskon_persen',
        'potongan_harga',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
    ];

    public function menuItems()
    {
        return $this->belongsToMany(\App\Models\MenuItem::class, 'menu_item_promotion');
    }
} 