<?php

namespace App\Repositories\AdminUser;

use App\Models\AdminUser;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface AdminUserRepositoryInterface
 * 
 * Defines the contract for the AdminUserRepositoryInterface
 */
interface AdminUserRepositoryInterface
{
    /**
     * Retrieve a list of all adminusers.
     *
     * @return Collection A collection of adminuser models.
     */
    public function index(): Collection;

    /**
     * Retrieve all admin users who have an assigned role.
     *
     * @return Collection A collection of admin users with a non-null role.
     */
    public function getAdminUserWithExistRole(): Collection;

    /**
     * Retrieve and display the details of a specific admin user.
     *
     * @param integer $userId The ID of the admin user.
     * @return AdminUser The admin user model instance.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException if no user is found
     */
    public function show(int $userId): AdminUser;

    /**
     * Retrieves all admin users along with their associated roles.
     *
     * @return Collection A collection of admin users with their roles.
     */
    public function getAdminUserWithRole(): Collection;

    /**
     * Store a newly created admin user in the database.
     *
     * @param object $data The object containing admin user details.
     * @return void
     */
    public function store(object $data): void;

    /**
     * Update the specified adminuser with the provided data.
     *
     * @param object $data The data object containing updated user information
     * @param integer $id The ID of the adminuser to update.
     * @return void
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException if the user is not found.
     */
    public function update(object $data, int $id): void;

    /**
     * Delete and adminuser by ID.
     *
     * @param integer $id The ID of the adminuser to delete.
     * @return void
     * @throws ModelNotFoundException If the user does not exist.
     */
    public function destroy(int $id): void;
}
