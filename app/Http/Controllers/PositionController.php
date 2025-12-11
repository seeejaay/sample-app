<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\PositionRequest;
use App\Services\PositionService\PositionServiceInterface;
class PositionController extends Controller
{
    protected $positionService;

    public function __construct(PositionServiceInterface $positionService)
    {
        $this->positionService = $positionService;
    }

    public function index(){
        try{
            return response()->json($this->positionService->getAllPositions());
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve positions', 'error' => $e->getMessage()], 500);
        } 
    }

    public function store(PositionRequest $request){
        try{
            $position = $this->positionService->createPosition($request->validated());
        
            return response()->json(['message'=>'Position Created Successfully', 'position'=> $position], 201);
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to create position', 'error' => $e->getMessage()], 500);
        } 
    }

    public function show($position){
        try {
            return response()->json($this->positionService->getPositionById($position));
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve position', 'error' => $e->getMessage()], 500);
        } 
    }

    public function update(PositionRequest $request, $position){
        try {

            $position = $this->positionService->updatePosition($position, $request->validated());
            return response()->json(['message'=>'Position Updated Successfully', 'position'=>$position], 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to update position', 'error' => $e->getMessage()], 500);
        } 
    }

    public function destroy($position){
        try {

            $this->positionService->deletePosition($position);
            return response()->json(['message'=>'Position Deleted Successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to delete position', 'error' => $e->getMessage()], 500);
        } 
    }
}
