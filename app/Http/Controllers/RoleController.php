<?php
namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Http\Requests\RoleRequest;
use App\Services\RoleService\RoleServiceInterface;
class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleServiceInterface $roleService){
        $this->roleService = $roleService;
    }


    // View All Roles
    public function index(){
        try{
            return response()->json($this->roleService->getAllRoles());
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve roles', 'error' => $e->getMessage()], 500);
        }
    }

    //Create Role
    public function store(RoleRequest $request){
        try{
           $role = $this->roleService->createRole($request->validated());
            return response()->json(['message'=>'Role Created Successfully', 'role'=> $role], 201);
        }
        catch (Exception $e) {
            return response()->json(['message'=>'Failed to create role', 'error' => $e->getMessage()], 500);
        }
    }

    //View Role By ID
    public function show($role){
        try {
            return response()->json($this->roleService->getRoleById($role));
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve role', 'error' => $e->getMessage()], 500);
        }
    }

    //Update Role
    public function update(RoleRequest $request, $role){
        try {

            $role = $this->roleService->updateRole($role, $request->validated());
            return response()->json(['message'=>'Role Updated Successfully', 'role'=>$role], 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to update role', 'error' => $e->getMessage()], 500);
        }
    }

    //Delete Role
    public function destroy($role){
        try {

            $this->roleService->deleteRole($role);
            return response()->json(['message'=>'Role Deleted Successfully'], 204);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to delete role', 'error' => $e->getMessage()], 500);
        }
    }
}