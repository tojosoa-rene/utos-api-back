<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Users extends Model implements AuthenticatableContract, JWTSubject
{
    use Authenticatable;

    protected $fillable = ['username', 'email', 'password', 'role_id'];

    protected $hidden = ['password'];

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    // JWT
    public function getJWTIdentifier()
    {
        return $this->id; // 👈 SOLUTION TSOTRA
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}