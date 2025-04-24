<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable; 

class PenjualanModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier(){ 
        return $this->getKey();
    }
    
    public function getJWTCustomClaims(){ 
        return [];
    }

    protected $table = 't_penjualan';
    protected $primaryKey = 'penjualan_id';
    public $timestamps = false; // karena kolom created_at & updated_at NULL

    protected $fillable = [
        'user_id',
        'pembeli',
        'penjualan_kode',
        'penjualan_tanggal',
        'image',
    ];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => $image ? url('/storage/transaksi/' . $image) : null
        );
    }

    

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke detail transaksi
    public function details()
    {
        return $this->hasMany(PenjualanDetailModel::class, 'penjualan_id', 'penjualan_id');
    }

    public function barang()
    {
        return $this->hasManyThrough(
            BarangModel::class,
            PenjualanDetailModel::class,
            'penjualan_id', // Foreign key di PenjualanDetailModel
            'barang_id',    // Foreign key di BarangModel
            'penjualan_id', // Local key di PenjualanModel
            'barang_id'     // Local key di PenjualanDetailModel
        );
    }
    

    // Di dalam PenjualanModel
    public function stok()
    {
        return $this->hasMany(PenjualanDetailModel::class, 'penjualan_id');
    }
    


    
}
