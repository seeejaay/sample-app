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
        return $this->model->get();
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getAllForExport()
    {
        return $this->model->with(['role', 'position', 'schedules'])->get();
    }
    
}