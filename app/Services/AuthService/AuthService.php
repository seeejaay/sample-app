<?php

namespace App\Services\AuthService;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthService implements AuthServiceInterface
{
    public function login(array $credentials)
    {
        // Implement login logic here
        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new Exception('Email or Password may be Incorrect');
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logout($user)
    {
        // Implement logout logic here
        $user->currentAccessToken()->delete();
        return true;
    }
}