<?php

namespace App\Repositories\Role;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface RoleRepositoryInterface
 * 
 * Defines the contract for the RoleRepository
 */
interface RoleRepositoryInterface
{
    /**
     * Retrieve all roles.
     *
     * @return Collection A collection of all roles.
     */
    public function index(): Collection;

    /**
     * Retrieve and display the details of a specific role.
     *
     * @param integer $roleId The ID of the role.
     * @return Role The role model instance.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException if no role is found
     * 
     */
    public function show(int $roleId): Role;

    /**
     * Store a newly created role in the database.
     *
     * @param string $name The name of the role to be stored.
     * @return void
     */
    public function store(string $name): void;

    /**
     * Update the specified role with the given name.
     *
     * @param string $name The new name for the role.
     * @param integer $id The ID of the role to update.
     * @return void
     */
    public function update(string $name, int $id): void;

    public function destroy(int $id): bool;
}
