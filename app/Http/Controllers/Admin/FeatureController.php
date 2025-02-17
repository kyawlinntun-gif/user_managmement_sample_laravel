<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Feature\CreateRequest;
use App\Http\Requests\Admin\Feature\UpdateRequest;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read,features')->only('index');
        $this->middleware('permission:create,features')->only(['create', 'store']);
        $this->middleware('permission:delete,features')->only('destroy');
    }

    public function index()
    {
        $features = Feature::all();
        return view('admin.feature.index', [
            'features' => $features
        ]);
    }

    public function create()
    {
        return view('admin.feature.create');
    }

    public function store(CreateRequest $request)
    {
        Feature::create([
            'name' => $request->feature_name
        ]);
        return redirect('/admin/features')->with('success', 'Feature created successfully!');
    }

    public function edit($id)
    {
        $feature = Feature::findOrFail($id);
        return view('admin.feature.edit', [
            'feature' => $feature
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $feature = Feature::findOrFail($id);
        $feature->update([
            'name' => $request->feature_name
        ]);
        return redirect('/admin/features')->with('success', 'Feature updated successfully!');
    }

    public function destroy($id)
    {
        $feature = Feature::findOrFail($id);
        if ($feature->permissions->isNotEmpty()) {
            return redirect()->back()->withErrors(['message' => 'This feature is linked to permissions!']);
        }
        $feature->delete();
        return redirect()->back()->with('success', 'Feature deleted successfully!');
    }
}
