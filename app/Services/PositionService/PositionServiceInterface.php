<?php

namespace App\Services\PositionService;

interface PositionServiceInterface
{
    public function getAllPositions();
    public function createPosition(array $data);
    public function getPositionById($positionId);
    public function updatePosition($positionId, array $data);
    public function deletePosition($positionId);
}