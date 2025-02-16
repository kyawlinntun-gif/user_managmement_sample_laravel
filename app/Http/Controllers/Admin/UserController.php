<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminUser;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read,user')->only('index');
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

    }
}
