<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'kategori',
        'gambar',
        'status'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
