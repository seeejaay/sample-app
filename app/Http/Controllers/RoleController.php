<?php
namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Exception;

class RoleController extends Controller
{
    // View All Roles
    public function index(){
        try{
            return response()->json(Role::all());
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve roles', 'error' => $e->getMessage()], 500);
        }
    }

    //Create Role
    public function create(Request $request){
        try{

            $validated = $request->validate([
                'name' => 'required|string|unique:roles,name',
                'description' => 'nullable|string',
            ]);
            $role = Role::create($validated);
            return response()->json(['message'=>'Role Created Successfully', 'role'=> $role], 201);
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to create role', 'error' => $e->getMessage()], 500);
        }
    }

    //View Role By ID
    public function read($id){
        try {
            return response()->json(Role::findOrFail($id));
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve role', 'error' => $e->getMessage()], 500);
        }
    }

    //Update Role
    public function update(Request $request, $id){
        try {

            $role = Role::findOrFail($id);
            $validated = $request-> validate([
                'name' => 'sometimes|required|string|unique:roles,name,'.$role->id,
                'description' => 'nullable|string',
            ]);
            $role->update($validated);
            return response()->json(['message'=>'Role Updated Successfully', 'role'=>$role], 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to update role', 'error' => $e->getMessage()], 500);
        }
    }

    //Delete Role
    public function delete($id){
        try {

            $role = Role::findOrFail($id);
            $role->delete();
            return response()->json(['message'=>'Role Deleted Successfully'], 204);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to delete role', 'error' => $e->getMessage()], 500);
        }
    }
}