<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_customer',
        'menu_item_id',
        'rating',
        'komentar',
        'tanggal',
    ];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
} 