<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\ScheduleRequest;
use App\Http\Resources\ScheduleResource\ScheduleResource;
use App\Http\Resources\ScheduleResource\ScheduleDropdownResource;
use App\Http\Resources\UserResource\UserMinimalResource;
use App\Repository\ScheduleRepository\ScheduleRepositoryInterface;
class ScheduleController extends Controller
{
    protected $scheduleRepository;
    public function __construct(
        ScheduleRepositoryInterface $scheduleRepository,
    ){
        $this->scheduleRepository = $scheduleRepository;
    }

    // Simple CRUD - use Repository
    public function index(){
        try{
            $schedule = $this->scheduleRepository->getAll();
            return response()->json(ScheduleResource::collection($schedule));
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve schedules', 'error' => $e->getMessage()], 500);
        }
    }

    public function dropdown(){
        try{
            $schedule = $this->scheduleRepository->getAll();
            return response()->json(ScheduleDropdownResource::collection($schedule));
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve schedules', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(ScheduleRequest $request){
        try{
            $schedule = $this->scheduleRepository->create($request->validated());
            return response()->json([
            'message'=>'Schedule Created Successfully', 
            'schedule'=> new ScheduleResource($schedule)], 201);
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to create schedule', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($schedule){
        try {
            $schedule = $this->scheduleRepository->findById($schedule);
            return new ScheduleResource($schedule);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve schedule', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(ScheduleRequest $request, $schedule){
        try {
            $schedule = $this->scheduleRepository->update($schedule, $request->validated());
            return response()->json([
            'message'=>'Schedule Updated Successfully', 
            'schedule'=> new ScheduleResource($schedule)], 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to update schedule', 'error' => $e->getMessage()], 500);
        }
    }

    // Delete - use Service (has business validation)
    public function destroy($schedule){
        try {
            $this->scheduleRepository->delete($schedule);
            return response()->json(['message'=>'Schedule Deleted Successfully'], 204);
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            return response()->json(['message' => $e->getMessage()], $statusCode);
        }
    }

    public function getUsers($schedule){
        try {
            $users = $this->scheduleRepository->getUsersByScheduleId($schedule);
            return UserMinimalResource::collection($users);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve users', 'error' => $e->getMessage()], 500);
        }
    }
}