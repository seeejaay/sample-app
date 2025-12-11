<?php

namespace App\Services\UserScheduleService;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Exception;

class UserScheduleService implements UserScheduleServiceInterface{

    public function assignScheduleToUser(array $data){
        DB::beginTransaction();

        try{
            $user = User::findOrFail($data['user_id']);

            if (!Schedule::find($data['schedule_id'])) {
                throw new Exception('Schedule not found');
            }

            if ($user->schedules()->where('schedule_id', $data['schedule_id'])->exists()) {
                throw new Exception('Schedule already assigned to user');
            }

            if ($user->schedules()->count() >= 2) {
                throw new Exception('User cannot be assigned to more than two schedules');
            }

            $user->schedules()->attach($data['schedule_id']);

            DB::commit();

            return $user->load('schedules:id,shift_name,time_in,time_out');
        } catch (Exception $e){
            DB::rollBack();
            throw new Exception('Failed to assign schedule to user: ' . $e->getMessage());
        }
    }


    public function removeScheduleFromUser($userId, $scheduleId)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($userId);

            if(!$user->schedules()->where('schedule_id',$scheduleId)->exists()){
                throw new Exception('Schedule not assigned to user');
            }

            $user->schedules()->detach($scheduleId);

            DB::commit();

            return $user->load('schedules:id,shift_name,time_in,time_out');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Failed to remove schedule from user: ' . $e->getMessage());
        }
    }

    public function getSchedulesByUserId($userId)
    {
        try {
            $user = User::findOrFail($userId);
            return $user->schedules()->get(['id', 'shift_name', 'time_in', 'time_out']);
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve schedules for user: ' . $e->getMessage());
        }
    }
}