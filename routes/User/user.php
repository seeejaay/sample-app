<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::controller(UserController::class)->prefix('users')->group(function(){
    Route::get('profile', 'profile')->name('users.profile');
});

Route::apiResource('users', UserController::class);