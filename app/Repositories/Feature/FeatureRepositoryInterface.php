<?php

namespace App\Repositories\Feature;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Collection;

/**
 *  Interface FeatureRepositoryInterface
 * 
 * Defines the contract for the FeatureReposiotryInterface
 */
interface FeatureRepositoryInterface
{
    /**
     * Retrieve a list of all features.
     *
     * @return Collection A collection of feature models.
     */
    public function index(): Collection;

    /**
     * Store a newly created feature in the database.
     *
     * @param string $featureName The name of the feature to be created.
     * @return void
     */
    public function store(string $featureName): void;

    /**
     * Display the feature with specified ID.
     *
     * @param integer $id The ID of the feature to retrieve.
     * @return Feature The requested feature model.
     * @throws ModelNotFoundException If the feature with the given ID does not exist.
     */
    public function show(int $id): Feature;

    /**
     * Update the specified feature in the database.
     *
     * @param string $featureName The new name of the feature.
     * @param integer $id The ID of the feature to update.
     * @return void
     */
    public function update(string $featureName, int $id): void;

    public function destroy(int $id): bool;
}
