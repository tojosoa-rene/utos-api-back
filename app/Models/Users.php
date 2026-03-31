<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    //
    protected $fillable = ['username', 'email', 'password', 'role_id'];
    
    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }
}
