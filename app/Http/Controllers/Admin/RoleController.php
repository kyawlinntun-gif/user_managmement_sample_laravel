<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\StoreRequest;
use App\Http\Requests\Admin\Role\UpdateRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {   
        $this->middleware('permission:read,role')->only('index');
        $this->middleware('permission:create,role')->only(['create', 'store']);
        $this->middleware('permission:update,role')->only(['edit', 'update']);
        $this->middleware('permission:delete,role')->only('destroy');
    }
    public function index()
    {
        $roles = Role::all();
        return view('admin.role.index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        return view('admin.role.create');
    }

    public function store(StoreRequest $request)
    {
        $role = new Role();
        $role->name = $request->role_name;
        $role->save();
        return redirect('/admin/roles')->with('success', 'Role created successfully!');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.role.edit', [
            'role' => $role
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->name = $request->role_name;
        $role->update();
        return redirect('/admin/roles')->with('success', 'Role updated successfully!');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        // Check if the role is associated with any users
        if ($role->adminUsers()->exists()) {
            return back()->withErrors(['message' => 'Cannot delete this role because it is assigned to users.']);
        }
        $role->delete();
        return redirect('/admin/roles')->with('success', 'Role deleted successfully!');
    }
}
