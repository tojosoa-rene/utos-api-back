<?php
namespace App\Repositories;
use App\Models\Users;

class UserRepository
{
    public function create(array $data)
    {
        return Users::create($data);
    }

    public function findByEmail(string $email)
    {
        return Users::where('email', $email)->first();
    }
}