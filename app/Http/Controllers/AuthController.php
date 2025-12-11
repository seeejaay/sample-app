<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Hash;
use App\Services\AuthService\AuthServiceInterface;

class AuthController extends Controller{

    protected $authService;
    public function __construct(AuthServiceInterface $authService){
        $this->authService = $authService;
    }




    public function login(AuthRequest $request){
        try {
           $resule = $this->authService->login($request->validated());

            return response()->json([
                'message'=>'Login Successful',
                'user'=>$resule['user'],
                'token'=> $resule['token']
            ]);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to login', 'error' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request){
        try{
           $this->authService->logout($request->user());
            return response()->json(['message'=>'Logged out successfully'], 200);
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to logout', 'error' => $e->getMessage()], 500);
        }
    }
}