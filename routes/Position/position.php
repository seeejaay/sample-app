<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PositionController;

Route::apiResource('positions', PositionController::class);