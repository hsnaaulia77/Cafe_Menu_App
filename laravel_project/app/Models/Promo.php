<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'jenis',
        'nilai',
        'kode_kupon',
        'minimum_pembelian',
        'maksimal_penggunaan',
        'sudah_digunakan',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
        'menu_bundle',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
        'menu_bundle' => 'array',
        'nilai' => 'decimal:2',
        'minimum_pembelian' => 'decimal:2',
    ];

    public function isActive()
    {
        return $this->status === 'aktif' && 
               now()->between($this->tanggal_mulai, $this->tanggal_berakhir) &&
               ($this->maksimal_penggunaan === null || $this->sudah_digunakan < $this->maksimal_penggunaan);
    }

    public function canBeUsed()
    {
        return $this->isActive();
    }
}
