<?php


namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\PositionRequest;
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
            return response()->json($this->positionRepository->getAll());
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve positions', 'error' => $e->getMessage()], 500);
        } 
    }

    public function store(PositionRequest $request){
        try{
            $position = $this->positionRepository->create($request->validated());
            return response()->json(['message'=>'Position Created Successfully', 'position'=> $position], 201);
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to create position', 'error' => $e->getMessage()], 500);
        } 
    }

    public function show($position){
        try {
            return response()->json($this->positionRepository->findById($position));
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve position', 'error' => $e->getMessage()], 500);
        } 
    }

    public function update(PositionRequest $request, $position){
        try {
            $position = $this->positionRepository->update($position, $request->validated());
            return response()->json(['message'=>'Position Updated Successfully', 'position'=>$position], 200);
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