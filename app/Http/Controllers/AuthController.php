<?php

namespace App\Http\Controllers;

use App\Models\User;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller{

    public function login(Request $request){
        try {
            $credentials = $request->validate([
                'email'=>'required|email',
                'password'=>'required|string',
            ]);

            $user = User::where('email', $credentials['email'])->first();

            if(!$user || !Hash::check($credentials['password'], $user->password)){
                return response()->json(['message'=>'Email or Password may be Incorrect'], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message'=>'Login Successful',
                'user'=>$user,
                'token'=> $token
            ]);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to login', 'error' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request){
        try{
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message'=>'Logged out successfully'], 200);
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to logout', 'error' => $e->getMessage()], 500);
        }
    }
}