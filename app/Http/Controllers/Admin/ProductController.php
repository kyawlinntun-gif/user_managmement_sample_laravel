<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class ProductController
 * 
 * Handles actions related to products
 */
class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;
    /**
     * @var ProductService
     */
    private ProductService $productService;

    /**
     * Create a new controller instance and apply necessary middleware.
     *
     * @param ProductRepositoryInterface $productRepository
     * @param ProductService $productService
     */
    public function __construct(ProductRepositoryInterface $productRepository, ProductService $productService)
    {
        $this->middleware('permission:read,product')->only('index');
        $this->middleware('permission:create,product')->only(['create', 'store']);
        $this->middleware('permission:update,product')->only(['edit', 'update']);
        $this->middleware('permission:delete,product')->only('destroy');
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }

    /**
     * Display a list of products
     *
     * @return View The view with the list of products
     */
    public function index(): View
    {
        $products = $this->productRepository->index();
        return view('admin.product.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new product.
     *
     * @return View The view for creating a new product.
     */
    public function create(): View
    {
        return view('admin.product.create');
    }

    /**
     * Handle the product creation process and store it in the database.
     *
     * @param CreateRequest $request The request instance containing product data.
     * @return RedirectResponse Redirect response indicating success or failure.
     */
    public function store(CreateRequest $request): RedirectResponse
    {
        $image = $request->file('image');
        $imageName = $this->productService->store($image);
        $this->productRepository->store($request->product_name, $request->description, $imageName);
        return redirect('/admin/products')->with('success', 'Product created successfully!');
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param integer $id The ID of the product to edit.
     * @return View The view for editing the product.
     */
    public function edit(int $id): View
    {
        $product = $this->productRepository->show($id);
        return view('admin.product.edit', [
            'product' => $product
        ]);
    }

    /**
     * Update the product with the given ID using the provided request data.
     *
     * @param UpdateRequest $request The request containing the updated product details.
     * @param [type] $id The ID of the product to update.
     * @return RedirectResponse A redirect response back to the products index page with a success message
     */
    public function update(UpdateRequest $request, $id): RedirectResponse
    {
        $this->productRepository->update($id, $request->product_name, $request->description);
        return redirect('/admin/products')->with('success', 'Product updated successfully!');
    }

    /**
     * Delete the product with the given ID and redriect to the product list page.
     *
     * @param integer $id The ID of the product to delete.
     * @return RedirectResponse Redirect response to the product list page with a success message.
     * @throws ModelNotFoundException If the product with the given ID is not found.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->productRepository->destroy($id);
        return redirect('/admin/products')->with('success', 'Product deleted successfully!');
    }
}
