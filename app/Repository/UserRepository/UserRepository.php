<?php

namespace App\Repository\UserRepository;

use App\Models\User;
use App\Repository\BaseRepository\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        return $this->model->with('role', 'position')->get();
    }

    public function findById($id)
    {
        return $this->model
            ->with([
                'role:id,name', 
                'position:id,name', 
                'schedules:id,shift_name,time_in,time_out'
            ])
            ->findOrFail($id);
    }
    
    public function attachSchedules($user, array $scheduleIds)
    {
        $user->schedules()->attach($scheduleIds);
    }

    public function syncSchedules($user, array $scheduleIds)
    {
        $user->schedules()->sync($scheduleIds);
    }
}