<?php

namespace App\Repository\UserRepository;

use App\Repository\BaseRepository\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function attachSchedules($user, array $scheduleIds);
    public function syncSchedules($user, array $scheduleIds);
}