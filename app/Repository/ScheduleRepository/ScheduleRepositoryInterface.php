<?php

namespace App\Repository\ScheduleRepository;

use App\Repository\BaseRepository\BaseRepositoryInterface;

interface ScheduleRepositoryInterface extends BaseRepositoryInterface
{
    // Custom method to get users by schedule
    public function getUsersByScheduleId($id);
    
}