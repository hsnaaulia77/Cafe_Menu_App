<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'nama', 'kategori_id', 'deskripsi', 'harga', 'gambar', 'status', 'stok', 'promo_aktif'
    ];

    public function kategori()
    {
        return $this->belongsTo(\App\Models\Category::class, 'kategori_id');
    }

    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }

    public function promotions()
    {
        return $this->belongsToMany(\App\Models\Promotion::class, 'menu_item_promotion');
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class, 'menu_item_id');
    }
}
