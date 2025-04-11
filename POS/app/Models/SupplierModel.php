<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory;

    protected $table = 'm_supplier'; // Nama tabel
    protected $primaryKey = 'supplier_id'; // Primary key tabel
    public $timestamps = true; // Atur sesuai dengan tabel kamu (true jika ada created_at & updated_at)

    protected $fillable = [
        'supplier_kode',
        'supplier_nama',
        'supplier_alamat',
        'supplier_telepon',
    ];

    // Relasi ke tabel stok
    public function stok()
    {
        return $this->hasMany(StokModel::class, 'supplier_id', 'supplier_id');
    }
}
