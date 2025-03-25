<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ProductRepositoryInterface
 * 
 * Defines the contract for the ProductRepository
 */
interface ProductRepositoryInterface
{
    /**
     * Retrieve a list of all products.
     *
     * @return Collection A collection of Product models.
     */
    public function index(): Collection;

    /**
     * Retrieve a product by its ID.
     *
     * @param integer $id The ID of the product to retrieve.
     * @return Product The requested product instance.
     * @throws ModelNotFoundException if the product is not found.
     */
    public function show(int $id): Product;

    /**
     * Store a new product in the database.
     *
     * @param string $productName The name of the product.
     * @param string $description The description of the product.
     * @param string $imageName The name of the product image file.
     * @return void
     */
    public function store(string $productName, string $description, string $imageName): void;

    /**
     * Update the product with the given ID.
     *
     * @param integer $id The ID of the product to update.
     * @param string $productName The new name for the product.
     * @param string $description The new description for the product.
     * @return void
     */
    public function update(int $id, string $productName, string $description): void;

    /**
     * Delete the product with the given ID and remove its associated image file.
     *
     * @param integer $id The ID of the product to delete.
     * @return void
     * 
     * @throws ModelNotFoundException If the product with the given ID is not found.
     */
    public function destroy(int $id): void;
}
