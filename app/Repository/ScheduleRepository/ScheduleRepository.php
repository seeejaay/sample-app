<?php
namespace App\Repository\ScheduleRepository;

use App\Models\Schedule;
use App\Repository\BaseRepository\BaseRepository;

class ScheduleRepository extends BaseRepository implements ScheduleRepositoryInterface
{
    public function __construct(Schedule $model)
    {
        parent::__construct($model);
    }

    public function getUsersByScheduleId($id)
    {
        $schedule = $this->model->with('users:id,firstname,lastname,email')->findOrFail($id);
        return $schedule->users;
    }

}