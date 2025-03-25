<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Repositories\Product\ProductRepositoryInterface;

/**
 * Class HomeController
 * 
 * This controller handles the homepage and retrieves product data using the productRepository. 
 */
class HomeController extends Controller
{
    /**
     *
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * HomeController constructor
     *
     * @param ProductRepositoryInterface $productRepository The product respository instance.
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display the homepage with a list of products.
     *
     * @return View The home view with product data.
     */
    public function index(): View
    {
        $products = $this->productRepository->index();
        return view('home', [
            'products' => $products
        ]);
    }
}
