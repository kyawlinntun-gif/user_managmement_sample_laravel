<?php

namespace App\Services;

use App\Http\Requests\AllUpdateRequest;
use App\Repositories\AdminUser\AdminUserRepositoryInterface;
use App\Repositories\Permission\PermissionRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;

/**
 * Class AdminHomeService
 */
class AdminHomeService
{
    /**
     * @var AdminUserRepositoryInterface
     */
    private AdminUserRepositoryInterface $adminUserRepository;
    /**
     * @var RoleRepositoryInterface
     */
    private RoleRepositoryInterface $roleRepository;
    /**
     * @var PermissionRepositoryInterface
     */
    private PermissionRepositoryInterface $permissionRepository;

    /**
     * AdminHomeService constructor.
     *
     * @param AdminUserRepositoryInterface $adminUserRepository The repository for admin users.
     * @param RoleRepositoryInterface $roleRepository The repository for roles.
     * @param PermissionRepositoryInterface $permissionRepository The repository for permissions.
     */
    public function __construct(AdminUserRepositoryInterface $adminUserRepository, RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository)
    {
        $this->adminUserRepository = $adminUserRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Updates the roles and permissions of adminusers.
     *
     * @param array $features An associative array mapping user IDs to feature IDs.
     * @param array $permissions An associative array mapping user IDs to permission IDs.
     * @return void
     */
    public function allUpdate(array $features, array $permissions): void
    {
        $adminUser = $this->adminUserRepository->getAdminUserWithExistRole();
        $roles = [];
        foreach($adminUser as $user) {
            $roles[$user->id] = $user->role_id;
        }
        foreach ($roles as $userId => $roleId) {
            $adminUser = $this->adminUserRepository->show($userId);
            if(!$adminUser) {
                continue;
            }
            $adminUser->role_id = $roleId;
            $adminUser->save();
            $role = $this->roleRepository->show($roleId);
            if(!$role) {
                continue;
            }
            $role->permissions()->detach();
            if(!empty($permissions[$userId])) {
                $validPermissions = $this->permissionRepository->getPermissionWithAssociatedFeature($permissions[$userId] ?? [], $features[$userId] ?? []);
                $role->permissions()->sync($validPermissions);
            }
        }
    }
}
