<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class UserRepository implements UserInterface {
    public function register(RegisterRequest $request) {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }

    public function login(LoginRequest $request) {
        $login = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if ($login) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('auth_token')->plainTextToken;
            return ['access_token' => $token];
        }
        return false;
    }
}
