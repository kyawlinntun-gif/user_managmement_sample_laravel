<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feature;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permission\CreateRequest;
use App\Http\Requests\Admin\Permission\UpdateRequest;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read,permissions')->only('index');
        $this->middleware('permission:create,permissions')->only(['create', 'store']);
        $this->middleware('permission:update,permissions')->only(['edit', 'update']);
        $this->middleware('permission:delete,permissions')->only('destroy');
    }

    public function index()
    {
        $permissions = Permission::with('feature')->get();
        return view('admin.permission.index', [
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        $features = Feature::all();
        return view('admin.permission.create', [
            'features' => $features
        ]);
    }

    public function store(CreateRequest $request)
    {
        $exists = Permission::where('name', $request->permission_name)
                                ->where('feature_id', $request->feature_id)
                                ->exists();
        if($exists) {
            return redirect()->back()->withInput($request->all())
                                        ->withErrors(['message' => 'Permission already exists!']);
        }
        Permission::create([
            'name' => $request->permission_name,
            'feature_id' => $request->feature_id
        ]);

        return redirect('/admin/permissions')->with('success', 'Permission created successfully!');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $features = Feature::all();
        return view('admin.permission.edit', [
            'permission' => $permission,
            'features' => $features
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $exists = Permission::where('name', $request->permission_name)
                            ->where('feature_id', $request->feature_id)
                            ->where('id', '!=', $id)
                            ->exists();
        if ($exists) {
            return redirect()->back()
                            ->withInput($request->all())
                            ->withErrors(['message' => 'Permission already exists!']);
        }
        $permission->update([
            'name' => $request->permission_name,
            'feature_id' => $request->feature_id
        ]);
        return redirect('/admin/permissions')->with('success', 'Permission updated successfully!');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        if ($permission->roles->isNotEmpty()) {
            return redirect()->back()->withErrors(['message' => 'Cannot delete: Permission is assigned to a role!']);
        }
        $permission->delete();
        return redirect()->back()->with('success', 'Permission deleted successfully!');
    }

}
