<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_peminjam',
        'nama_barang',
        'gudang_id',
        'stok',
        'status',
    ];

    public function gudang(){
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }

    public static function boot(){
        parent::boot();

        static::creating(function ($peminjaman){
            $gudang = Gudang::find($peminjaman->gudang_id);
            if ($gudang && $gudang->stok >= $peminjaman->stok){
                $gudang->decrement('stok', $peminjaman->stok);
            } else{
                throw new \Exception("Stok tidak ada!");
            }
        });

        static::updating(function ($peminjaman){
            if ($peminjaman->isDirty('status') && $peminjaman->status == 'dikembalikan'){
                $gudang = Gudang::find($peminjaman->gudang_id);
                if ($gudang){
                    $gudang->increment('stok', $peminjaman->stok);
                }
            }
        });
    }
}
