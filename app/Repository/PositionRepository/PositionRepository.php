<?php

namespace App\Repository\PositionRepository;

use App\Models\Position;
use App\Repository\BaseRepository\BaseRepository;

class PositionRepository extends BaseRepository implements PositionRepositoryInterface
{
    public function __construct(Position $model)
    {
        parent::__construct($model);
    }

}