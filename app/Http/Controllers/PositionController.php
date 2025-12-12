<?php


namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\PositionRequest;
use App\Http\Resources\PositionResource\PositionResource;
use App\Http\Resources\PositionResource\PositionDropdownResource;
use App\Repository\PositionRepository\PositionRepositoryInterface;

class PositionController extends Controller
{
    protected $positionRepository;

    public function __construct(
        PositionRepositoryInterface $positionRepository,
    ){
        $this->positionRepository = $positionRepository;

    }

    public function index(){
        try{
            $user = $this->positionRepository->getAll();

            return response()->json(PositionResource::collection($user));
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve positions', 'error' => $e->getMessage()], 500);
        } 
    }

    public function dropdown(){
        try{
            $user = $this->positionRepository->getAll();

            return response()->json(PositionDropdownResource::collection($user));
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve positions', 'error' => $e->getMessage()], 500);
        } 
    }




    public function store(PositionRequest $request){
        try{
            $position = $this->positionRepository->create($request->validated());
            return response()->json(['message'=>'Position Created Successfully', 'position'=> new PositionResource($position)], 201);
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to create position', 'error' => $e->getMessage()], 500);
        } 
    }

    public function show($position){
        try {
            $position = $this->positionRepository->findById($position);
            return new PositionResource($position);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve position', 'error' => $e->getMessage()], 500);
        } 
    }

    public function update(PositionRequest $request, $position){
        try {
            $position = $this->positionRepository->update($position, $request->validated());
            return response()->json(['message'=>'Position Updated Successfully', 'position'=> new PositionResource($position)], 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to update position', 'error' => $e->getMessage()], 500);
        } 
    }

    public function destroy($position){
        try {
            $this->positionRepository->delete($position);
            return response()->json(['message'=>'Position Deleted Successfully'], 204);
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            return response()->json(['message' => $e->getMessage()], $statusCode);
        } 
    }
}