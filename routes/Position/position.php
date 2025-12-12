<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PositionController;

Route::controller(PositionController::class)
->prefix('positions')
->group(function () {
    Route::get('dropdown', 'dropdown')->name('positions.dropdown');
});


Route::apiResource('positions', PositionController::class);