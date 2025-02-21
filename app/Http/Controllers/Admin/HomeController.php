<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Feature;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AllUpdateRequest;
use App\Models\Permission;

class HomeController extends Controller
{
    public function index()
    {
        $admin_users = AdminUser::all();
        $features = Feature::all();
        $permissions = Permission::all();
        return view('admin.home', [
            'admin_users' => $admin_users,
            'features' => $features,
            'permissions' => $permissions
        ]);
    }

    public function allUpdate(AllUpdateRequest $request)
    {
        $features = $request->has('features') ? $request->get('features') : [];
        $permissions = $request->has('permissions') ? $request->get('permissions') : [];
        $admin_users = AdminUser::whereNotNull('role_id')->get();
        $roles = [];
        foreach($admin_users as $user) {
            $roles[$user->id] = $user->role_id;
        }
        foreach ($roles as $user_id => $role_id) {
            $adminUser = AdminUser::find($user_id);
            if(!$adminUser) {
                continue;
            }
            $adminUser->role_id = $role_id;
            $adminUser->save();
            $role = Role::find($role_id);
            if(!$role) {
                continue;
            }
            $role->permissions()->detach();
            if(!empty($permissions[$user_id])) {
                $validPermissions = Permission::whereIn('id', $permissions[$user_id])->whereIn('feature_id', $features[$user_id])->pluck('id')->toArray();
                $role->permissions()->sync($validPermissions);
            }
        }

        return redirect()->back()->with('success', 'Updated successfully!');
    }
}
