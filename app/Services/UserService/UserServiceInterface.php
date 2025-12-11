<?php

namespace App\Services\UserService;


interface UserServiceInterface
{

    public function getAllUsers();
    public function createUser(array $data);
    public function getUserById($userId);
    public function updateUser($userId, array $data);
    public function deleteUser($userId);
    public function getUserProfile($user);
}