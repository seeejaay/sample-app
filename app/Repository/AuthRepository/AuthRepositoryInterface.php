<?php

namespace App\Repository\AuthRepository;

interface AuthRepositoryInterface
{
    public function findByEmail($email);
}