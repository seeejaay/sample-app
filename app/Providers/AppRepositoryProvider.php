<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;


// Repositories
use App\Repository\AuthRepository\AuthRepository;
use App\Repository\AuthRepository\AuthRepositoryInterface;

use App\Repository\UserRepository\UserRepository;
use App\Repository\UserRepository\UserRepositoryInterface;

use App\Repository\RoleRepository\RoleRepository;
use App\Repository\RoleRepository\RoleRepositoryInterface;

use App\Repository\PositionRepository\PositionRepository;
use App\Repository\PositionRepository\PositionRepositoryInterface;

use App\Repository\ScheduleRepository\ScheduleRepository;
use App\Repository\ScheduleRepository\ScheduleRepositoryInterface;

use App\Repository\UserScheduleRepository\UserScheduleRepository;
use App\Repository\UserScheduleRepository\UserScheduleRepositoryInterface;


class AppRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        // Repositories
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PositionRepositoryInterface::class, PositionRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ScheduleRepositoryInterface::class, ScheduleRepository::class);
        $this->app->bind(UserScheduleRepositoryInterface::class, UserScheduleRepository::class);


    }
    
    public function boot(): void
    {
        //
    }
}