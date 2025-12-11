<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    //View All Users
    public function index(){
        return response()->json(User::with('role')->get());
    }

    //Create User
    public function store(UserRequest $request){
        DB::beginTransaction();
        
        try{
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            
            $user = User::create($validated);
            if($request->has('schedule_ids') &&$request->schedule_ids){
                
                if(count($request->schedule_ids) > 2){
                    return response()->json([
                        'message' => 'User cannot be assigned to more than two schedules.'
                    ], 422);
                }

                foreach($request->schedule_ids as $scheduleId){
                        if (!Schedule::find($scheduleId)) {
                            return response()->json([
                                'message' => "Schedule with ID {$scheduleId} does not exist."
                            ], 422);
                        }
                    }
                $user->schedules()->attach($request->schedule_ids);
            }
            DB::commit();

            $user ->load('role', 'position','schedules:id,shift_name,time_in,time_out');
        
            return response()->json(['message'=>'User Created Successfully', 'user'=> $user],201);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message'=>'Failed to create user', 'error' => $e->getMessage()], 500);
        }
    }

    //View User By ID
    public function show($id){
        try {
            $user = User::findOrFail($id);
            $user->load(['role:id,name','position:id,name','schedules:id,shift_name,time_in,time_out']);
            
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
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $validated = $request->validated();

            if(isset($validated['password'])){
                $validated['password'] = Hash::make($validated['password']);
            }
            
            $user->update($validated);

             if($request->has('schedule_ids') &&$request->schedule_ids){
                
                if(count($request->schedule_ids) > 2){
                    return response()->json([
                        'message' => 'User cannot be assigned to more than two schedules.'
                    ], 422);
                }

                foreach($request->schedule_ids as $scheduleId){
                        if (!Schedule::find($scheduleId)) {
                            return response()->json([
                                'message' => "Schedule with ID {$scheduleId} does not exist."
                            ], 422);
                        }
                    }
                $user->schedules()->sync($request->schedule_ids);
            }
            DB::commit();
            $user->load('role', 'position','schedules:id,shift_name,time_in,time_out');
            
            return response()->json(['message'=>'User Updated Successfully', 'user'=>$user], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message'=>'Failed to update user', 'error' => $e->getMessage()], 500);
        }
    }


    //Delete user
    public function destroy($id){
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