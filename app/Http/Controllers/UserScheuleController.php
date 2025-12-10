<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Exception;

class UserScheuleController extends Controller
{
    //
    public function index(){
        try {
            return response()->json(Schedule::all());
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve schedules'], 500);
        }
    }

    

}
