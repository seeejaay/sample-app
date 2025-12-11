<?php
namespace App\Services\ScheduleService;

use App\Repository\ScheduleRepository\ScheduleRepositoryInterface;

class ScheduleService implements ScheduleServiceInterface
{
    protected $scheduleRepository;

    public function __construct(ScheduleRepositoryInterface $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

}