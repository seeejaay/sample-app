<?php

namespace App\Repository\RoleRepository;

use App\Models\Role;
use App\Repository\BaseRepository\BaseRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

}