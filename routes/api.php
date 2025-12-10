<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserScheduleController;

//Public Routes
    //Authentication Routes
    Route::prefix('v1')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->name('login');

        Route::post('register', [UserController::class, 'create']);
        Route::post('roles', [RoleController::class, 'create']);
    });

//Protected Routes
Route::prefix('v1')->middleware('auth:sanctum')->group(function(){
    //CRUD Routes for USERS
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'create']);
    Route::get('users/{id}', [UserController::class, 'read']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'delete']);
    //Current User Profile
    Route::get('profile', [UserController::class, 'profile']);
    //CRUD Routes for ROLES
    Route::get('roles', [RoleController::class, 'index']);
    // Route::post('roles', [RoleController::class, 'create']);
    Route::get('roles/{id}', [RoleController::class, 'read']);
    Route::put('roles/{id}', [RoleController::class, 'update']);
    Route::delete('roles/{id}', [RoleController::class, 'delete']);

    //Route for Position
    Route::get('positions', [PositionController::class, 'index']);
    Route::post('positions', [PositionController::class, 'create']);
    Route::get('positions/{id}', [PositionController::class, 'read']);
    Route::put('positions/{id}', [PositionController::class, 'update']);
    Route::delete('positions/{id}', [PositionController::class, 'delete']);

    //Routes for Schedule
    Route::get('schedules', [ScheduleController::class, 'index']);
    Route::post('schedules', [ScheduleController::class, 'create']);
    Route::get('schedules/{id}', [ScheduleController::class, 'read']);
    Route::put('schedules/{id}', [ScheduleController::class, 'update']);
    Route::delete('schedules/{id}', [ScheduleController::class, 'delete']);

    //Routes for User Schedules
    Route::post('user-schedules', [UserScheduleController::class, 'assign'])->name('user-schedules.assign');
    Route::delete('user-schedules', [UserScheduleController::class, 'unassign'])->name('user-schedules.unassign');
    Route::get('user-schedules/{user_id}', [UserScheduleController::class, 'getUserSchedules']);




    //Authentication Routes
    Route::post('logout', [AuthController::class, 'logout']);
});