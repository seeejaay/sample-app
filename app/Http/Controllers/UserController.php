<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller {

    //View All Users
    public function index(){
        return response()->json(User::with('role')->get());
    }

    //Create User
    public function create(Request $request){
        try{
            $validated = $request->validate([
                'firstname' => 'required|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/',
                'role_id' => 'required|exists:roles,id',
            ]);

            $user = User::create($validated);
        
            return response()->json(['message'=>'User Created Successfully', 'user'=> $user],201);
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to create user', 'error' => $e->getMessage()], 500);
        }
    }

    //View User By ID
    public function read($id){
        try {
            $user = User::find($id);
            if(!$user){
                return response()->json(['message'=>'User not found'],404);
            }
            return response()->json($user);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve user', 'error' => $e->getMessage()], 500);
        }
    }


    //Edit User
    public function update(Request $request,$id){
        try {
        $user = User::find($id);
        if(!$user){
            return response()->json(['message'=>'User not found'],404);
        }

        $validated = $request->validate([
            'full_name' => 'sometimes|required|string|max:255|regex:/^[a-zA-Z\s]+$/|unique:users,full_name,'.$user->id,
            'email' => 'sometimes|required|email|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|string|min:8|confirmed|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/',
            'role_id' => 'sometimes|required|exists:roles,id',
        ]);
        $user->update($validated);
        return response()->json(['message'=>'User Updated Successfully', 'user'=>$user],200);
    } catch (Exception $e) {
        return response()->json(['message'=>'Failed to update user', 'error' => $e->getMessage()], 500);
    }
    }

    //Delete user
    public function delete($id){
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message'=>'User Deleted Successfully'],204);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to delete user', 'error' => $e->getMessage()], 500);
        }
    }

    //Current User Profile
    public function profile(Request $request){
        try {
            $user = $request->user();
            return response()->json($user);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve profile', 'error' => $e->getMessage()], 500);
        }
    }

}