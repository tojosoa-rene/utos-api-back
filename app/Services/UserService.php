<?php
namespace App\Services;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {
        // Exemple logique métier
        if ($this->userRepository->findByEmail($data['email'])) {
            throw new \Exception("Email already exists");
        }

        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }
}