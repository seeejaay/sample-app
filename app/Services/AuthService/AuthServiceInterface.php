<?php

namespace App\Services\AuthService;

interface AuthServiceInterface
{
    // public function register(array $data);
    public function login(array $credentials);
    public function logout($userId);

}