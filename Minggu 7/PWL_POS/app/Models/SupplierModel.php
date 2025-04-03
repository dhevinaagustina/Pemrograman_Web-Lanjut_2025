<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory;
    protected $table = 'm_supplier'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'supplier_id'; // Sesuaikan dengan primary key tabel

    protected $fillable = [
        'supplier_kode',
        'supplier_nama',
        'supplier_alamat',
        'supplier_telepon',
    ];
}
