<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserScheduleController;

Route::controller(UserScheduleController::class)
->prefix('user-schedules')
->group(function(){
    Route::post('/', 'assign')->name('user_schedules.assign');
    Route::delete('/', 'unassign')->name('user_schedules.unassign');
    Route::get('{user_id}', 'getUserSchedules')->name('user_schedules.get_user_schedules');
});