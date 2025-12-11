<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\AuthService\AuthService;
use App\Services\AuthService\AuthServiceInterface;

use App\Services\UserService\UserService;
use App\Services\UserService\UserServiceInterface;

use App\Services\RoleService\RoleService;
use App\Services\RoleService\RoleServiceInterface;

use App\Services\PositionService\PositionService;
use App\Services\PositionService\PositionServiceInterface;

use App\Services\ScheduleService\ScheduleService;
use App\Services\ScheduleService\ScheduleServiceInterface;

use App\Services\UserScheduleService\UserScheduleService;
use App\Services\UserScheduleService\UserScheduleServiceInterface;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(PositionServiceInterface::class, PositionService::class);
        $this->app->bind(ScheduleServiceInterface::class, ScheduleService::class);
        $this->app->bind(UserScheduleServiceInterface::class, UserScheduleService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
