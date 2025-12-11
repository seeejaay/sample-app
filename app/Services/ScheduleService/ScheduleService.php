<?php

namespace App\Services\ScheduleService;

use App\Models\Schedule;

class ScheduleService implements ScheduleServiceInterface
{
    
    public function getAllSchedules(){
        return Schedule::all();
    }

    public function createSchedule(array $data){
        return Schedule::create($data);
    }

    public function getScheduleById($scheduleId){
        return Schedule::findOrFail($scheduleId);
    }

    public function updateSchedule($scheduleId, array $data){
        $schedule = Schedule::findOrFail($scheduleId);
        $schedule->update($data);
        return $schedule;
    }

    public function deleteSchedule($scheduleId){
        $schedule = Schedule::findOrFail($scheduleId);
        $schedule->delete();
    }

    public function getUsersByScheduleId($scheduleId){
        $schedule = Schedule::findOrFail($scheduleId);
        return $schedule->users;
    }

}