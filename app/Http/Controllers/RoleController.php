<?php
namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\RoleRequest;
use App\Repository\RoleRepository\RoleRepositoryInterface;

class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
    ){
        $this->roleRepository = $roleRepository;
    }
    public function index(){
        try{
            return response()->json($this->roleRepository->getAll());
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve roles', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(RoleRequest $request){
        try{
            $role = $this->roleRepository->create($request->validated());
            return response()->json(['message'=>'Role Created Successfully', 'role'=> $role], 201);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to create role', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($role){
        try {
            return response()->json($this->roleRepository->findById($role));
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to retrieve role', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(RoleRequest $request, $role){
        try {
            $role = $this->roleRepository->update($role, $request->validated());
            return response()->json(['message'=>'Role Updated Successfully', 'role'=>$role], 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Failed to update role', 'error' => $e->getMessage()], 500);
        }
    }

    // Delete - use Service (has business validation)
    public function destroy($role){
        try {
            $this->roleRepository->delete($role);
            return response()->json(['message'=>'Role Deleted Successfully'], 204);
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            return response()->json(['message' => $e->getMessage()], $statusCode);
        }
    }
}