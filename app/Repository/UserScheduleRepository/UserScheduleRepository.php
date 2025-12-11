<?php

namespace App\Repository\UserScheduleRepository;

use App\Models\User;

class UserScheduleRepository implements UserScheduleRepositoryInterface
{
    public function attachSchedule($user, $scheduleId)
    {
        $user->schedules()->attach($scheduleId);
    }

    public function detachSchedule($user, $scheduleId)
    {
        $user->schedules()->detach($scheduleId);
    }

    public function hasSchedule($user, $scheduleId)
    {
        return $user->schedules->contains($scheduleId);
    }

    public function getScheduleCount($user)
    {
        return $user->schedules()->count();
    }

    public function getSchedulesByUserId($userId)
    {
        $user = User::with('schedules')->findOrFail($userId);
        return $user->schedules;
    }
}