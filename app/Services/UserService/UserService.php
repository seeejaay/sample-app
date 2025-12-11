<?php
namespace App\Services\UserService;

use App\Models\Schedule;
use App\Repository\UserRepository\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService implements UserServiceInterface {

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(){
        return $this->userRepository->getAll();
    }

    public function createUser(array $data){
        DB::beginTransaction();

        try {
            // Business Logic: Hash password
            if(isset($data['password'])){
                $data['password'] = Hash::make($data['password']);
            }

            // Repository: Create user
            $user = $this->userRepository->create($data);

            // Business Logic: Validate and attach schedules
            if(isset($data['schedule_ids']) && !empty($data['schedule_ids'])){
                $this->validateSchedules($data['schedule_ids']);
                $this->userRepository->attachSchedules($user, $data['schedule_ids']);
            }

            DB::commit();

            // Repository: Reload with relationships
            return $this->userRepository->findById($user->id);

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getUserById($userId){
        return $this->userRepository->findById($userId);
    }

    public function updateUser($userId, array $data){
        DB::beginTransaction();

        try{
            // Business Logic: Hash password
            if(isset($data['password'])){
                $data['password'] = Hash::make($data['password']);
            }

            // Repository: Update user
            $user = $this->userRepository->update($userId, $data);

            // Business Logic: Validate and sync schedules
            if(array_key_exists('schedule_ids', $data)){
                if (!empty($data['schedule_ids'])){
                    $this->validateSchedules($data['schedule_ids']);
                }
                $this->userRepository->syncSchedules($user, $data['schedule_ids']);
            }

            DB::commit();

            // Repository: Reload with relationships
            return $this->userRepository->findById($userId);

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteUser($userId){
        $this->userRepository->delete($userId);
        return true;
    }

    public function getUserProfile($user){
        return $user;
    }

    // Business Logic: Validation stays in Service
    private function validateSchedules(array $scheduleIds){
        if (count($scheduleIds) > 2){
            throw new Exception('User cannot be assigned to more than two schedules.', 422);
        }
        $existingSchedules = Schedule::whereIn('id', $scheduleIds)->pluck('id')->toArray();
        $missingSchedules = array_diff($scheduleIds, $existingSchedules);
        
        if (!empty($missingSchedules)){
            throw new Exception("Schedule(s) with ID(s) " . implode(', ', $missingSchedules) . " do not exist.", 422);
        }
    }
}