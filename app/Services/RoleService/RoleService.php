<?php

namespace App\Services\RoleService;

use App\Models\Role;
// use Illuminate\Support\Facades\DB;


class RoleService implements RoleServiceInterface {

    public function getAllRoles(){
        return Role::all();
    }

    public function createRole(array $data){
        return Role::create($data);
    }

    public function getRoleById($roleId){
        return Role::findOrFail($roleId);
    }

    public function updateRole($roleId, array $data){
        $role = Role::findOrFail($roleId);
        $role->update($data);
        return $role;
    }

    public function deleteRole($roleId){
        $role = Role::findOrFail($roleId);
        $role->delete();
    }
}
