<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Exports\UsersExport\UsersExport;
use App\Http\Requests\UserRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\UserResource\UserResource;
use App\Services\UserService\UserServiceInterface;
use App\Repository\UserRepository\UserRepositoryInterface;

class UserController extends Controller {

    protected $userRepository;
    protected $userService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserServiceInterface $userService
    ){
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function index(){
        try {
            $users = $this->userRepository->getAll();

            return response()->json(UserResource::collection($users));
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to retrieve users', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(UserRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->validated());
            
            return response()->json([
                'message' => 'User Created Successfully',
                'user' => new UserResource($user)
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create user',
                'error' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

    public function show($user){
        try {
            $user = $this->userRepository->findById($user);
            return new UserResource($user);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to retrieve user', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(UserRequest $request, $user){
        try {
            $user = $this->userService->updateUser($user, $request->validated());
            return response()->json([
            'message' => 'User Updated Successfully',
            'user' => new UserResource($user)
        ], 200);
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            return response()->json(['message' => $e->getMessage()], $statusCode);
        }
    }

    public function destroy($user){
        try {
            $this->userRepository->delete($user);
            return response()->json(['message' => 'User Deleted Successfully'], 204);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to delete user', 'error' => $e->getMessage()], 500);
        }
    }

    public function profile(Request $request){
        try {
            $user = $request->user();
            return new UserResource($user);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to retrieve profile', 'error' => $e->getMessage()], 500);
        }
    }

    public function export()
    {
        try {
            $users = $this->userService->exportUsers();
            return Excel::download(new UsersExport($users), 'users-' . now()->format('Y-m-d') . '.xlsx');
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to export users', 'error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}