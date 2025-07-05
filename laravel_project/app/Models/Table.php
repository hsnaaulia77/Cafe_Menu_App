<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory;
    protected $fillable = ['number', 'status', 'kapasitas', 'lokasi'];

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }
}
