<?php

namespace App\Repository\UserScheduleRepository;

interface UserScheduleRepositoryInterface
{
    public function attachSchedule($user, $scheduleId);
    public function detachSchedule($user, $scheduleId);
    public function getSchedulesByUserId($userId);

    public function hasSchedule($user, $scheduleId);
    public function getScheduleCount($user);
}