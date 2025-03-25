<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ProductRepository
 * 
 * Handles product-related data retrieval.
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Retrieve a list of all products.
     *
     * @return Collection A collection of Product models.
     */
    public function index(): Collection
    {
        return Product::all();
    }

    /**
     * Retrieve a product by its ID.
     *
     * @param integer $id The ID of the product to retrieve.
     * @return Product The requested product instance.
     * @throws ModelNotFoundException if the product is not found.
     */
    public function show(int $id): Product
    {
        return Product::findOrFail($id);
    }

    /**
     * Store a new product in the database.
     *
     * @param string $productName The name of the product.
     * @param string $description The description of the product.
     * @param string $imageName The name of the product image file.
     * @return void
     */
    public function store(string $productName, string $description, string $imageName): void
    {
        Product::create([
            'name' => $productName,
            'description' => $description,
            'image' => $imageName
        ]);
    }

    /**
     * Update the product with the given ID.
     *
     * @param integer $id The ID of the product to update.
     * @param string $productName The new name for the product.
     * @param string $description The new description for the product.
     * @return void
     */
    public function update(int $id, string $productName, string $description): void
    {
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $productName,
            'description' => $description
        ]);
    }

    /**
     * Delete the product with the given ID and remove its associated image file.
     *
     * @param integer $id The ID of the product to delete.
     * @return void
     * 
     * @throws ModelNotFoundException If the product with the given ID is not found.
     */
    public function destroy(int $id): void
    {
        $product = Product::findOrFail($id);
        $imagePath = public_path("assets/upload/{$product->image}");
        if ($product->delete()) {
            if (file_exists($imagePath) && $product->image !== '1739379536placeholder.png') {
                unlink($imagePath);
            }
        }
    }
}
