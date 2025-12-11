<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Http\Requests\ScheduleRequest;

class ScheduleController extends Controller
{
    //
    public function index()
    {
        try{
            $schedules = Schedule::all();
            return response()->json($schedules, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve schedules', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(ScheduleRequest $request)
    {
        try{
            $schedule = Schedule::create($request->validated());
            return response()->json($schedule, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create schedule', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try{
            $schedule = Schedule::findOrFail($id);
            return response()->json($schedule, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Schedule not found', 'error' => $e->getMessage()], 404);
        }
    }


    public function update(ScheduleRequest $request, $id)
    {
        try{
            $schedule = Schedule::findOrFail($id);
            $schedule->update($request->validated());
            return response()->json($schedule, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update schedule', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try{
            $schedule = Schedule::findOrFail($id);
            $schedule->delete();
            return response()->json(['message' => 'Schedule deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete schedule', 'error' => $e->getMessage()], 500);
        }
    }

    public function getUsers($id)
    {
        try{
            $schedule = Schedule::findOrFail($id);
            $users = $schedule->users;
            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve users for schedule', 'error' => $e->getMessage()], 500);
        }
    }
}
