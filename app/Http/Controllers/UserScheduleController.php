<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserScheduleRequest;
use Exception;

class UserScheduleController extends Controller
{
    //

    public function assign(UserScheduleRequest $request){
        try {

            $user = User::findorFail($request->user_id);


            if ($user->schedules->contains($request->schedule_id)) {
                return response()->json([
                    'message' => 'Schedule is already assigned to the user.'
                ], 422);
            }

             if ($user->schedules()->count() >= 2) {
                return response()->json([
                    'message' => 'User cannot be assigned to more than two schedules.'
                ], 422);
            }

            $user->schedules()->attach($request->schedule_id);

            return response()->json([
                'message' => 'Schedule assigned to user successfully.'
            ], 200);    
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to assign schedule to user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function unassign(UserScheduleRequest $request){
        try {

            $user = User::findorFail($request->user_id);

           if (!$user->schedules()->where('schedule_id', $request->schedule_id)->exists()) {
                return response()->json([
                    'message' => 'Schedule is not assigned to the user.'
                ], 422);
        }

            $user->schedules()->detach($request->schedule_id);

            return response()->json([
                'message' => 'Schedule unassigned from user successfully.'
            ], 200);    
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to unassign schedule from user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserSchedules($user_id){
        try {

            $user = User::findorFail($user_id);
            $schedules = $user->schedules;

            return response()->json([
                'status' => 'success',
                'data' => $schedules
            ], 200);    
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve user schedules.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
