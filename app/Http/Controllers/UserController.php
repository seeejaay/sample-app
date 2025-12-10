<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller {

    //View All Users
    public function index(){
        return response()->json(User::with('role')->get());
    }

    //Create User
    public function create(UserRequest $request){
        try{
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            
            $user = User::create($validated);
            $user ->load('role', 'position');
        
            return response()->json(['message'=>'User Created Successfully', 'user'=> $user],201);
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to create user', 'error' => $e->getMessage()], 500);
        }
    }

    //View User By ID
    public function read($id){
        try {
            $user = User::with('role')->with('position')->find($id);
            
            if(!$user){
                return response()->json(['message'=>'User not found'],404);
            }
            return response()->json($user);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve user', 'error' => $e->getMessage()], 500);
        }
    }


    //Edit User
    public function update(UserRequest $request, $id){
        try {
            $user = User::findOrFail($id);
            $validated = $request->validated();

            if(isset($validated['password'])){
                $validated['password'] = Hash::make($validated['password']);
            }
            
            $user->update($validated);
            $user->load('role', 'position');
            
            return response()->json(['message'=>'User Updated Successfully', 'user'=>$user], 200);
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