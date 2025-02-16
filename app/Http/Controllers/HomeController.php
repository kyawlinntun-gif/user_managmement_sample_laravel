<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $product = new Product();
        $products = $product->all();
        return view('home', [
            'products' => $products
        ]);
    }
}
