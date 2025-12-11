<?php

namespace App\Services\PositionService;

use App\Models\Position;

class PositionService implements PositionServiceInterface
{
    // Implement service methods here
    public function getAllPositions(){
        return Position::all();
        // Logic to get all positions
    }

    public function createPosition(array $data){
        return Position::create($data);
        // Logic to create a new position
    }
    public function getPositionById($positionId){
        return Position::findOrFail($positionId);
        // Logic to get a position by ID
    }
    public function updatePosition($positionId, array $data){
        $position = Position::findOrFail($positionId);
        $position->update($data);
        return $position;
        // Logic to update a position
    }
    public function deletePosition($positionId){
        $position = Position::findOrFail($positionId);
        $position->delete();
        // Logic to delete a position
    }
}