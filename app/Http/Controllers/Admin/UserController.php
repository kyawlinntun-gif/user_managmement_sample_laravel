<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Http\Requests\Admin\User\UpdateRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read,user')->only('index');
        $this->middleware('permission:create,user')->only(['create', 'store']);
        $this->middleware('permission:update,user')->only(['edit', 'update']);
        $this->middleware('permission:delete,user')->only('destroy');
    }

    public function index()
    {
        $admin_users = AdminUser::with('role')->get();
        return view('admin.user.index', [
            'admin_users' => $admin_users
        ]);
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', [
            'roles' => $roles
        ]);
    }

    public function store(StoreRequest $request)
    {
        $admin_user = new AdminUser();
        $admin_user->name = $request->name;
        $admin_user->username = $request->username;
        $admin_user->role_id = $request->role_id;
        $admin_user->phone = $request->phone;
        $admin_user->email = $request->email;
        $admin_user->password = password_hash($request->password, PASSWORD_BCRYPT);
        $admin_user->address = $request->address;
        $admin_user->gender = $request->gender;
        $admin_user->is_active = $request->is_active;
        $admin_user->save();

        return redirect('/admin/users')->with('success', 'User created successfully!');
    }

    public function edit($id)
    {
        $user = AdminUser::findOrFail($id);
        $roles = Role::all();
        return view('admin.user.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $admin_user = AdminUser::findOrFail($id);
        $admin_user->name = $request->name;
        $admin_user->username = $request->username;
        $admin_user->role_id = $request->role_id;
        $admin_user->phone = $request->phone;
        $admin_user->email = $request->email;
        $admin_user->address = $request->address;
        $admin_user->gender = $request->gender;
        $admin_user->is_active = $request->is_active;
        $admin_user->update();

        return redirect('/admin/users')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $admin_user = AdminUser::findOrFail($id);
        $admin_user->delete();
        return redirect('/admin/users')->with('success', 'User deleted successfully!');
    }
}
