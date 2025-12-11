<?php

namespace App\Services\UserScheduleService;

interface UserScheduleServiceInterface
{
    public function assignScheduleToUser(array $data);
    public function removeScheduleFromUser($userId, $scheduleId);
    public function getSchedulesByUserId($userId);
}