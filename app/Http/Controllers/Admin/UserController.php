<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Repositories\AdminUser\AdminUserRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class UserController
 * 
 * Handles the management of admin users.
 */
class UserController extends Controller
{
    /**
     * @var AdminUserRepositoryInterface
     */
    private AdminUserRepositoryInterface $adminUserRepository;
    /**
     * @var RoleRepositoryInterface
     */
    private RoleRepositoryInterface $roleRepository;

    /**
     * UserController constructor.
     *
     * @param AdminUserRepositoryInterface $adminUserRepository
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(AdminUserRepositoryInterface $adminUserRepository, RoleRepositoryInterface $roleRepository)
    {
        $this->middleware('permission:read,user')->only('index');
        $this->middleware('permission:create,user')->only(['create', 'store']);
        $this->middleware('permission:update,user')->only(['edit', 'update']);
        $this->middleware('permission:delete,user')->only('destroy');
        $this->adminUserRepository = $adminUserRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of admin users along with their roles.
     *
     * @return View The view displaying the list of admin users.
     */
    public function index(): View
    {
        $adminUsers = $this->adminUserRepository->getAdminUserWithRole();
        return view('admin.user.index', [
            'adminUsers' => $adminUsers
        ]);
    }

    /**
     * Show the form for creating a new adminuser.
     *
     * @return View The view for creating an admin user.
     */
    public function create(): View
    {
        $roles = $this->roleRepository->index();
        return view('admin.user.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Handle the request to store a new admin user.
     *
     * @param StoreRequest $request The validated request containing user data.
     * @return RedirectResponse Redirects to the users list with a success message.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->adminUserRepository->store($request);
        return redirect('/admin/users')->with('success', 'User created successfully!');
    }

    /**
     * Show the form for editing the specified adminuser.
     *
     * @param int $id The ID of the admin user to edit.
     * @return View The view displaying the edit form with user and role data.
     */
    public function edit(int $id): View
    {
        $user = $this->adminUserRepository->show($id);
        $roles = $this->roleRepository->index();
        return view('admin.user.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Handle the request to update an existing adminuser.
     *
     * @param UpdateRequest $request The validated request containing updated user data.
     * @param int $id The ID of the adminuser to update.
     * @return RedirectResponse Redirects to the users list with a success message.
     */
    public function update(UpdateRequest $request, $id): RedirectResponse
    {
        $this->adminUserRepository->update($request, $id);
        return redirect('/admin/users')->with('success', 'User updated successfully!');
    }

    /**
     * Handle the request to delete an adminuser.
     *
     * @param integer $id The ID of the adminuser to delete.
     * @return RedirectResponse A redirect response to the admin users list with a success message.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->adminUserRepository->destroy($id);
        return redirect('/admin/users')->with('success', 'User deleted successfully!');
    }
}
