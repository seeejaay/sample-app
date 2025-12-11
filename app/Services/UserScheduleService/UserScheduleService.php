<?php

namespace App\Services\UserScheduleService;

use App\Repository\UserRepository\UserRepositoryInterface;
use App\Repository\UserScheduleRepository\UserScheduleRepositoryInterface;
use App\Repository\ScheduleRepository\ScheduleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class UserScheduleService implements UserScheduleServiceInterface
{
    protected $userRepository;
    protected $userScheduleRepository;
    protected $scheduleRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserScheduleRepositoryInterface $userScheduleRepository,
        ScheduleRepositoryInterface $scheduleRepository
    ){
        $this->userRepository = $userRepository;
        $this->userScheduleRepository = $userScheduleRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    public function assignScheduleToUser(array $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->findById($data['user_id']);
            $schedule = $this->scheduleRepository->findById($data['schedule_id']);

            if ($this->userScheduleRepository->hasSchedule($user, $schedule->id)) {
                throw new Exception('Schedule is already assigned to the user.', 422);
            }

            if ($this->userScheduleRepository->getScheduleCount($user) >= 2) {
                throw new Exception('User cannot be assigned to more than two schedules.', 422);
            }

            $this->userScheduleRepository->attachSchedule($user, $schedule->id);

            DB::commit();
            return true;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function removeScheduleFromUser($userId, $scheduleId)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->findById($userId);

            if (!$this->userScheduleRepository->hasSchedule($user, $scheduleId)) {
                throw new Exception('Schedule is not assigned to the user.', 422);
            }

            $this->userScheduleRepository->detachSchedule($user, $scheduleId);

            DB::commit();
            return true;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getSchedulesByUserId($userId)
    {
        return $this->userScheduleRepository->getSchedulesByUserId($userId);
    }
}