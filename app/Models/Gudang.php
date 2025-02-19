<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gudang extends Model
{
    use HasFactory;
    protected $fillable = [
        'kategori_barang',
        'nama_barang',
        'stok',
        'status',
    ];

    public function peminjaman(){
        return $this->hasMany(Peminjaman::class, 'gudang_id');
    }
}
