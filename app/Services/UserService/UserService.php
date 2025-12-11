<?php

namespace App\Services\UserService;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService implements UserServiceInterface {

    public function getAllUsers(){
        return User::with('role')->get();
    }

    public function createUser(array $data){
        DB::beginTransaction();

        try {
            if(isset($data['password'])){
                $data['password'] = Hash::make($data['password']);
            }

            $user = User::create($data);

            if(isset($data['schedule_ids']) && !empty($data['schedule_ids'])){
                $this->validateSchedules($data['schedule_ids']);
                $user->schedules()->attach($data['schedule_ids']);
            }

            DB::commit();

            $user->load('role', 'position', 'schedules:id,shift_name,time_in,time_out');

            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getUserById($userId){
        $user = User::findOrFail($userId);
        $user->load(['role:id,name', 'position:id,name', 'schedules:id,shift_name,time_in,time_out']);
        return $user;
    }

    public function updateUser($userId, array $data){
    DB::beginTransaction();

    try{
        $user = User::findOrFail($userId);

        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);

        if(array_key_exists('schedule_ids', $data)){
            if (!empty($data['schedule_ids'])){
                $this->validateSchedules($data['schedule_ids']);
            }
           
            $user->schedules()->sync($data['schedule_ids']);
        }

        DB::commit();

        $user->load('role', 'position', 'schedules:id,shift_name,time_in,time_out');

        return $user;
    } catch (Exception $e) {
        DB::rollBack();
        throw $e;
    }
}

    public function deleteUser($userId){
        $user = User::findOrFail($userId);
        $user->delete();
        return true;
    }

    public function getUserProfile($user){
        return $user;
    }

    private function validateSchedules(array $scheduleIds){
        if (count($scheduleIds) > 2){
            throw new Exception('User cannot be assigned to more than two schedules.', 422);
        }
        $existingSchedules = Schedule::whereIn('id', $scheduleIds)->pluck('id')->toArray();
        $missingSchedules = array_diff($scheduleIds, $existingSchedules);
        
        if (!empty($missingSchedules)){
            throw new Exception("Schedule(s) with ID(s) " . implode(', ', $missingSchedules) . " do not exist.", 422);
        }
    }
}