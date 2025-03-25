<?php

namespace App\Repositories\Role;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RoleRepository
 * 
 * Handles role-related data retrieval.
 */
class RoleRepository implements RoleRepositoryInterface
{
    /**
     * Retrieve all roles.
     *
     * @return Collection A collection of all roles.
     */
    public function index(): Collection
    {
        return Role::all();
    } 

    /**
     * Retrieve and display the details of a specific role.
     *
     * @param integer $roleId The ID of the role.
     * @return Role The role model instance.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException if no role is found
     * 
     */
    public function show(int $roleId): Role
    {
        return Role::findOrFail($roleId);
    }

    /**
     * Store a newly created role in the database.
     *
     * @param string $name The name of the role to be stored.
     * @return void
     */
    public function store(string $name): void
    {
        $role = new Role();
        $role->name = $name;
        $role->save();
    }

    /**
     * Update the specified role with the given name.
     *
     * @param string $name The new name for the role.
     * @param integer $id The ID of the role to update.
     * @return void
     */
    public function update(string $name, int $id): void
    {
        $role = Role::findOrFail($id);
        $role->name = $name;
        $role->update();
    }

    /**
     * Delete a role if it has no associated adminusers.
     *
     * If the role is associated with adminusers, it cannot be deleted.
     * If there are no associated adminusers, the role is deleted.
     * 
     * @param integer $id The ID of the role to delete.
     * @return boolean `true` if the role has admin users and cannot be deleted, `false` if the role is deleted.
     */
    public function destroy(int $id): bool
    {
        $role = Role::findOrFail($id);
        if ($role->adminUsers()->exists()) {
            return true;
        }
        $role->delete();
        return false;
    }
}
