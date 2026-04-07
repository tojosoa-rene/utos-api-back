<?php

namespace App\Http\Controllers;
use App\Services\AuthService;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;    
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $authService;
    protected $userRepository;

    public function __construct(
        AuthService $authService, 
        UserRepository $userRepository
    )
    {
        $this->authService      = $authService;
        $this->userRepository   = $userRepository;
    }

    /**
     * Handle user login and return JWT token
     * @param Request $request
     */
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
            return response()->json([
                'success' => false,
                'error' => 'Invalid credentials'
                ], 401);
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

    /**
     * Simulation de la fonctionnalité "Mot de passe oublié"
     * @param Request $request
     */
    public function forgotPassword(Request $request)
    {
        $email = $request->input('email');

        // validation simple
        if (!$email) {
            return response()->json([
                'error' => 'Email is required'
            ], 400);
        }

        if (!$this->userRepository->findByEmail($email)) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
        
        // simulation (tsy mbola mandefa mail)
        return response()->json([
            'message' => 'Reset link sent (simulation)'
        ]);
    }
}