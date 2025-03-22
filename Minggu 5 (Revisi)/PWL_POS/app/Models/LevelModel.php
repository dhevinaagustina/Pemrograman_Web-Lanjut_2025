<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;



class LevelModel extends Model
{
    protected $table = 'm_level'; // Nama tabel sesuai database
    protected $primaryKey = 'level_id'; // Pastikan primary key sesuai dengan database
    protected $fillable = ['level_kode', 'level_name']; // Tambahkan level_kode agar bisa diakses
    public $timestamps = false; // Nonaktifkan timestamps karena tidak digunakan

    public function users(): HasMany
    {
        return $this->hasMany(UserModel::class, 'level_id', 'level_id');
    }
}

