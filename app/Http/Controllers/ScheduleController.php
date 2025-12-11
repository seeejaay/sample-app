<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Services\ScheduleService\ScheduleServiceInterface;

class ScheduleController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleServiceInterface $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }
        //
    public function index()
    {
        try{
            return response()->json($this->scheduleService->getAllSchedules(), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve schedules', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(ScheduleRequest $request)
    {
        try{
            $schedule = $this->scheduleService->createSchedule($request->validated());
            return response()->json($schedule, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create schedule', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($schedule)
    {
        try{
            $schedule = $this->scheduleService->getScheduleById($schedule);
            return response()->json($schedule, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Schedule not found', 'error' => $e->getMessage()], 404);
        }
    }


    public function update(ScheduleRequest $request, $schedule)
    {
        try{
            $schedule = $this->scheduleService->updateSchedule($schedule, $request->validated());
            return response()->json($schedule, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update schedule', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($schedule)
    {
        try{
            $this->scheduleService->deleteSchedule($schedule);
            return response()->json(['message' => 'Schedule deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete schedule', 'error' => $e->getMessage()], 500);
        }
    }

    public function getUsers($schedule)
    {
        try{
            $users = $this->scheduleService->getUsersByScheduleId($schedule);
            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve users for schedule', 'error' => $e->getMessage()], 500);
        }
    }
}
