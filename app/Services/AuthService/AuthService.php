<?php

namespace App\Services\AuthService;

use Exception;
use App\Repository\AuthRepository\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(array $credentials)
    {
        // Repository: Find user by email
        $user = $this->authRepository->findByEmail($credentials['email']);
        
        // Business Logic: Validate user exists and password is correct
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new Exception('Email or Password may be Incorrect', 401);
        }

        // Business Logic: Create authentication token
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logout($user)
    {
        // Business Logic: Delete current access token
        $user->currentAccessToken()->delete();
        return true;
    }
}