<?php

namespace App\Services\ScheduleService;

interface ScheduleServiceInterface
{
    public function getAllSchedules();
    public function createSchedule(array $data);
    public function getScheduleById($scheduleId);
    public function updateSchedule($scheduleId, array $data);
    public function deleteSchedule($scheduleId);
    public function getUsersByScheduleId($scheduleId);
    // Define service methods here
}