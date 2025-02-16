<?php

namespace App\Policies;

use App\Models\AdminUser;
use App\Models\Role;

class RolePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function hasRole(AdminUser $user, $roles = [])
    {
        return Role::hasRole($roles);
    } 
}
