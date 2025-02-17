<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read,product')->only('index');
        $this->middleware('permission:create,product')->only(['create', 'store']);
        $this->middleware('permission:update,product')->only(['edit', 'update']);
        $this->middleware('permission:delete,product')->only('destroy');
    }

    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', [
            'products' => $products
        ]);   
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(CreateRequest $request)
    {
        $imageName = '1739379536placeholder.png';
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('assets/upload'), $imageName);
        }

        Product::create([
            'name' => $request->product_name,
            'description' => $request->description,
            'image' => $imageName
        ]);
        return redirect('/admin/products')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.edit', [
            'product' => $product
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->product_name,
            'description' => $request->description
        ]);
        return redirect('/admin/products')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $imagePath = public_path("assets/upload/{$product->image}");
        if ($product->delete()) {
            if (file_exists($imagePath) && $product->image !== '1739379536placeholder.png') {
                unlink($imagePath);
            }
        }
        return redirect('/admin/products')->with('success', 'Product deleted successfully!');
    }
}
