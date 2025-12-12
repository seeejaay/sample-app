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
        return $this->model->findOrFail($id)
        ->users()
        ->get();
    }

}