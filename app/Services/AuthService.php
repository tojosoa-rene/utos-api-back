<?php

namespace App\Services;

use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login($credentials)
    {
        $user = Users::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            return $user; 
        }

        return null;
    }
}