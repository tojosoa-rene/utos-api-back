<?php

namespace App\Http\Controllers;
use App\Services\AuthService;
use Illuminate\Http\Request;    
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        // Pour Lumen (car Lumen ne fournit pas la méthode validate() par defaut)
        $validator = Validator::make($request->all(), [
            'email'     => 'required|string|email|max:150',
            'password'  => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = $this->authService->login($validator->validated());

        if (!$user) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        
        $token = app('auth')->login($user); // JWT token generation

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
            ],
            'token' => $token
        ]);
    }
}