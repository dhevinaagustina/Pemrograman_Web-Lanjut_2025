<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class Authenticatable

class UserModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier(){ 
        return $this->getKey();
    }
    
    public function getJWTCustomClaims(){ return [];
    }
    
    protected $table = 'm_user'; 
    protected $primaryKey = 'user_id';
    
    protected $fillable = [ 
        'username', 
        'nama', 
        'password', 
        'level_id', 
        'image'//tambahan
    ];
    
    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
    
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/posts/' . $image),
        );
    }
    

    /**
     * Relasi ke tabel level
     */
    // public function level(): BelongsTo
    // {
    //     return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    // }

    public function getRoleName(): string 
    {
        return $this->level->level_name;
    }

    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
    }

    public function getRole() 
    {
        return $this->level->level_kode;
    }
}