<?php

namespace App\Repositories\AdminUser;

use App\Models\AdminUser;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class AdminUserRepository
 * 
 * Handles adminuser-related data retrieval.
 */
class AdminUserRepository implements AdminUserRepositoryInterface
{
    /**
     * Retrieve a list of all adminusers.
     *
     * @return Collection A collection of adminuser models.
     */
    public function index(): Collection
    {
        return AdminUser::all();
    }

    /**
     * Retrieve all admin users who have an assigned role.
     *
     * @return Collection A collection of admin users with a non-null role.
     */
    public function getAdminUserWithExistRole(): Collection
    {
        return AdminUser::whereNotNull('role_id')->get();
    }

    /**
     * Retrieve and display the details of a specific admin user.
     *
     * @param integer $userId The ID of the admin user.
     * @return AdminUser The admin user model instance.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException if no user is found
     */
    public function show(int $userId): AdminUser
    {
        return AdminUser::findOrFail($userId);
    }

    /**
     * Retrieves all admin users along with their associated roles.
     *
     * @return Collection A collection of admin users with their roles.
     */
    public function getAdminUserWithRole(): Collection
    {
        return AdminUser::with('role')->get();
    }

    /**
     * Store a newly created admin user in the database.
     *
     * @param object $data The object containing admin user details.
     * @return void
     */
    public function store(object $data): void
    {
        $admin_user = new AdminUser();
        $admin_user->name = $data->name;
        $admin_user->username = $data->username;
        $admin_user->role_id = $data->role_id;
        $admin_user->phone = $data->phone;
        $admin_user->email = $data->email;
        $admin_user->password = password_hash($data->password, PASSWORD_BCRYPT);
        $admin_user->address = $data->address;
        $admin_user->gender = $data->gender;
        $admin_user->is_active = $data->is_active;
        $admin_user->save();
    }

    /**
     * Update the specified adminuser with the provided data.
     *
     * @param object $data The data object containing updated user information
     * @param integer $id The ID of the adminuser to update.
     * @return void
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException if the user is not found.
     */
    public function update(object $data, $id): void
    {
        $admin_user = AdminUser::findOrFail($id);
        $admin_user->name = $data->name;
        $admin_user->username = $data->username;
        $admin_user->role_id = $data->role_id;
        $admin_user->phone = $data->phone;
        $admin_user->email = $data->email;
        $admin_user->address = $data->address;
        $admin_user->gender = $data->gender;
        $admin_user->is_active = $data->is_active;
        $admin_user->update();
    }

    /**
     * Delete and adminuser by ID.
     *
     * @param integer $id The ID of the adminuser to delete.
     * @return void
     * @throws ModelNotFoundException If the user does not exist.
     */
    public function destroy(int $id): void
    {
        $adminUser = AdminUser::findOrFail($id);
        $adminUser->delete();
    }
}
