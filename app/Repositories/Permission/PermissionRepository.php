<?php

namespace App\Repositories\Permission;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PermissionRepository
 * 
 * Handles permission-related data retrieval.
 */
class PermissionRepository implements PermissionRepositoryInterface
{
    /**
     * Retrieve a list of all permissions.
     *
     * @return Collection A collection of feature models.
     */
    public function index(): Collection
    {
        return Permission::all();
    }

    /**
     * Retrieve permission IDs that are associated with the given feature IDs.
     * 
     * This method filters permissions based on the provided permission IDs and feature IDs.
     *
     * @param array $permissions An array of permission IDs to filter.
     * @param array $features An array of feature IDs to filter.
     * @return array An array of valid permission IDs that match the given features.
     */
    public function getPermissionWithAssociatedFeature(array $permissions, array $features): array
    {
        return Permission::whereIn('id', $permissions)
                            ->whereIn('feature_id', $features)
                            ->pluck('id')
                            ->toArray();
    }

    /**
     * Retrieve all permissions along with their associated features
     *
     * @return Collection A collection of permissions with their related features.
     */
    public function getPermissionWithFeature(): Collection
    {
        return Permission::with('feature')->get();
    }

    /**
     * Check if a feature exists in the permissions table.
     *
     * @param string $permissionName The name of the permission.
     * @param integer $featureId The ID of the feature.
     * @return boolean Returns true if the feature exists, otherwise false.
     */
    public function checkFeatureExistInPermission(string $permissionName, int $featureId): bool
    {
        return Permission::where('name', $permissionName)
                            ->where('feature_id', $featureId)
                            ->exists();
    }

    /**
     * Store a new permission in the database.
     *
     * @param string $permissionName The name of the permission.
     * @param integer $featureId The ID of the associated feature.
     * @return void
     */
    public function store(string $permissionName, int $featureId): void
    {
        Permission::create([
            'name' => $permissionName,
            'feature_id' => $featureId
        ]);
    }

    /**
     * Retrieve a specific permission by its ID.
     *
     * @param integer $id The ID of the permission to retrieve.
     * @return Permission The requested permission model instance.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException if the permission is not found.
     */
    public function show(int $id): Permission
    {
        return Permission::findOrFail($id);
    }

    /**
     * Check if a permission with the given name and feature ID already exists, excluding the given permission ID.
     *
     * @param string $permissionName The name of the permission.
     * @param integer $featureId The ID fot the associated feature.
     * @param integer $id The ID of the permission to exclude from the check.
     * @return boolean True if the permission exists, false otherwise.
     */
    public function checkPemissionExistById(string $permissionName, int $featureId, int $id): bool
    {
        return Permission::where('name', $permissionName)
                            ->where('feature_id', $featureId)
                            ->where('id', '!=', $id)
                            ->exists();
    }

    /**
     * Update the specified permission with a new name and feature ID.
     *
     * @param string $permissionName The new name for the permission.
     * @param integer $featureId The new feature ID associated with the permission
     * @param integer $id The ID of the permission to update.
     * @return void
     */
    public function update(string $permissionName, int $featureId, int $id): void
    {
        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $permissionName,
            'feature_id' => $featureId
        ]);
    }

    /**
     * Delete the specified permission.
     *
     * @param integer $id The ID of the permission to delete.
     * @return boolean Returns true if the permission is associated with roles and cannot be deleted, false if deletion was successful.
     */
    public function destroy(int $id): bool
    {
        $permission = Permission::findOrFail($id);
        if ($permission->roles->isNotEmpty()) {
            return true;
        }
        $permission->delete();
        return false;
    }
}
