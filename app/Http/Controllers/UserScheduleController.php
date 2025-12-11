<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserScheduleRequest;
use App\Services\UserScheduleService\UserScheduleServiceInterface;
use Exception;

class UserScheduleController extends Controller
{
    protected $userScheduleService;

    public function __construct(UserScheduleServiceInterface $userScheduleService)
    {
        $this->userScheduleService = $userScheduleService;
    }

    public function assign(UserScheduleRequest $request){
        try {
            $this->userScheduleService->assignScheduleToUser($request->validated());

            return response()->json([
                'message' => 'Schedule assigned to user successfully.'
            ], 200);
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            return response()->json([
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }

    public function unassign(UserScheduleRequest $request){
        try {
            $this->userScheduleService->removeScheduleFromUser(
                $request->user_id,
                $request->schedule_id
            );

            return response()->json([
                'message' => 'Schedule unassigned from user successfully.'
            ], 200);
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            return response()->json([
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }

    public function getUserSchedules($user_id){
        try {
            $schedules = $this->userScheduleService->getSchedulesByUserId($user_id);

            return response()->json([
                'status' => 'success',
                'data' => $schedules
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve user schedules.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}