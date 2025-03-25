<?php

namespace App\Repositories\Feature;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class FeatureRepository
 * 
 * Handles feature-related data retrieval.
 */
class FeatureRepository implements FeatureRepositoryInterface
{
    /**
     * Retrieve a list of all features.
     *
     * @return Collection A collection of feature models.
     */
    public function index(): Collection
    {
        return Feature::all();
    }

    /**
     * Store a newly created feature in the database.
     *
     * @param string $featureName The name of the feature to be created.
     * @return void
     */
    public function store(string $featureName): void
    {
        Feature::create([
            'name' => $featureName
        ]);
    }

    /**
     * Display the feature with specified ID.
     *
     * @param integer $id The ID of the feature to retrieve.
     * @return Feature The requested feature model.
     * @throws ModelNotFoundException If the feature with the given ID does not exist.
     */
    public function show(int $id): Feature
    {
        return Feature::findOrFail($id);
    }

    /**
     * Update the specified feature in the database.
     *
     * @param string $featureName The new name of the feature.
     * @param integer $id The ID of the feature to update.
     * @return void
     */
    public function update(string $featureName, int $id): void
    {
        $feature = Feature::findOrFail($id);
        $feature->update([
            'name' => $featureName
        ]);
    }

    /**
     * Delete the specified feature from the database if it is not associated with any permissions.
     *
     * @param integer $id The ID of the feature to delete.
     * @return boolean Returns `true` if the feature is associated with permissions and cannot be deleted, otherwise `false` after deletion.
     */
    public function destroy(int $id): bool
    {
        $feature = Feature::findOrFail($id);
        if ($feature->permissions->isNotEmpty())
        {
            return true;
        }
        $feature->delete();
        return false;
    }
}
