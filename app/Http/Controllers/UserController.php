<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function index()
    {
        return Users::all();
    }

    public function store(Request $request)
    {
        // Pour Lumen (car Lumen ne fournit pas la méthode validate() par defaut)
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:150|unique:users',
            'password' => 'required|string|max:255',
            // 'role_id' => 'nullable|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = $this->userService->register($validator->validated());
        
        return response()->json($user, 201);

    }

    public function show($id)
    {
        return Users::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $users = Users::findOrFail($id);
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        ]);
        $users->update($data);
        return response()->json($users);
    }

    public function destroy($id)
    {
        $users = Users::findOrFail($id);
        $users->delete();
        return response()->json(null, 204);
    }
}
