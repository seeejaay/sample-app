<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;


Route::controller(RoleController::class)
->prefix('roles')
->group(function(){
    Route::get('dropdown', 'dropdown')->name('roles.dropdown');
});



Route::apiResource('roles', RoleController::class);