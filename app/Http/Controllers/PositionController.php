<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use Exception;
use App\Http\Requests\PositionRequest;
class PositionController extends Controller
{
    
    public function index(){
        try{
            return response()->json(Position::all());
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve positions', 'error' => $e->getMessage()], 500);
        } 
    }
 
    public function store(PositionRequest $request){
        try{
            $validated = $request-> validated();
           
            $position = Position::create($validated);
            return response()->json(['message'=>'Position Created Successfully', 'position'=> $position], 201);
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to create position', 'error' => $e->getMessage()], 500);
        } 
    }

    public function show($id){
        try {
            return response()->json(Position::findOrFail($id));
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve position', 'error' => $e->getMessage()], 500);
        } 
    }

    public function update(PositionRequest $request, $id){
        try {

            $position = Position::findOrFail($id);
            $validated = $request->validated();
            $position->update($validated);
            return response()->json(['message'=>'Position Updated Successfully', 'position'=>$position], 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to update position', 'error' => $e->getMessage()], 500);
        } 
    }

    public function destroy($id){
        try {

            $position = Position::findOrFail($id);
            $position->delete();
            return response()->json(['message'=>'Position Deleted Successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to delete position', 'error' => $e->getMessage()], 500);
        } 
    }
}
