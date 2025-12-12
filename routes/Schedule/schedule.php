<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;

Route::controller(ScheduleController::class)
->prefix('schedules')
->group(function(){
    Route::get('dropdown','dropdown')->name('schedules.dropdown');
    Route::get('{schedule}/users','getUsers')->name('schedules.users');

});


Route::apiResource('schedules', ScheduleController::class);