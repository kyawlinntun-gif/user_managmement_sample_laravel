<?php

namespace App\Policies;

use App\Models\AdminUser;
use App\Models\Permission;

class PermissionPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function hasPermission(AdminUser $user, $permission, $feature)
    {
        return Permission::hasPermission($user, $permission, $feature);
    }
}
