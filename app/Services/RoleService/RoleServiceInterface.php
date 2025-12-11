<?php

namespace App\Services\RoleService;

interface RoleServiceInterface
{

    public function getAllRoles();
    public function createRole(array $data);
    public function getRoleById($roleId);
    public function updateRole($roleId, array $data);
    public function deleteRole($roleId);
}