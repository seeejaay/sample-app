<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Services\UserService\UserServiceInterface;

class UserController extends Controller {

    protected $userService;

    public function __construct(UserServiceInterface $userService){
        $this->userService = $userService;
    }

    //View All Users
    public function index(){
        try {
            return response()->json($this->userService->getAllUsers());
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to retrieve users', 'error' => $e->getMessage()], 500);
        }
    }

    //Create User
    public function store(UserRequest $request)
    {
        try {
            $data = $request->validated();
            $user = $this->userService->createUser($data);
            
            return response()->json([
                'message' => 'User Created Successfully',
                'user' => $user
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create user',
                'error' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

    //View User By ID
    public function show($user){
        try {
            $user = $this->userService->getUserById($user);
            return response()->json($user);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to retrieve user', 'error' => $e->getMessage()], 500);
        }
    }

    //Edit User
    public function update(UserRequest $request, $user){
        try {
            $user = $this->userService->updateUser($user, $request->validated());
            return response()->json(['message' => 'User Updated Successfully', 'user' => $user], 200);
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            return response()->json(['message' => $e->getMessage()], $statusCode);
        }
    }

    //Delete user
    public function destroy($user){
        try {
            $this->userService->deleteUser($user);
            return response()->json(['message' => 'User Deleted Successfully'], 204);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to delete user', 'error' => $e->getMessage()], 500);
        }
    }

    //Current User Profile
    public function profile(Request $request){
        try {
            $user = $this->userService->getUserProfile($request->user());
            return response()->json($user);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to retrieve profile', 'error' => $e->getMessage()], 500);
        }
    }
}