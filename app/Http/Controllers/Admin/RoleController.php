<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\StoreRequest;
use App\Http\Requests\Admin\Role\UpdateRequest;
use App\Repositories\Role\RoleRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class RoleController
 * 
 * Handles the management of role users.
 */
class RoleController extends Controller
{
    /**
     * @var RoleRepositoryInterface
     */
    private RoleRepositoryInterface $roleRepository;

    /**
     * RoleController constructor.
     *
     * @param RoleRepositoryInterface $roleRepository The role respository instance.
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->middleware('permission:read,role')->only('index');
        $this->middleware('permission:create,role')->only(['create', 'store']);
        $this->middleware('permission:update,role')->only(['edit', 'update']);
        $this->middleware('permission:delete,role')->only('destroy');
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of roles.
     * 
     * @return View the view displaying the list of roles.
     */
    public function index(): View
    {
        $roles = $this->roleRepository->index();
        return view('admin.role.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new role.
     *
     * @return View The view displaying the role creating form.
     */
    public function create(): View
    {
        return view('admin.role.create');
    }

    /**
     * Handle the request to store a new role.
     *
     * @param StoreRequest $request The validated request containing the role name.
     * @return RedirectResponse Redirects to the roles list with a success message.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->roleRepository->store($request->roleName);
        return redirect('/admin/roles')->with('success', 'Role created successfully!');
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param integer $id The ID of the role to edit.
     * @return View The edit role view.
     */
    public function edit(int $id): View
    {
        $role = $this->roleRepository->show($id);
        return view('admin.role.edit', [
            'role' => $role
        ]);
    }

    /**
     * Handle the request to update the specified role.
     *
     * @param UpdateRequest $request The validated request containing the updated role data.
     * @param [type] $id The ID of the role to update.
     * @return RedirectResponse A redirect response indicating the success of the operation.
     */
    public function update(UpdateRequest $request, $id): RedirectResponse
    {
        $this->roleRepository->update($request->roleName, $id);
        return redirect('/admin/roles')->with('success', 'Role updated successfully!');
    }

    /**
     * Delete a role if it is not assigned to any users.
     *
     * @param integer $id The ID of the role to delete.
     * @return RedirectResponse A redirect response with a success or error message.
     */
    public function destroy(int $id): RedirectResponse
    {
        $roleBool = $this->roleRepository->destroy($id);
        // Check if the role is associated with any users
        if ($roleBool) {
            return back()->withErrors(['message' => 'Cannot delete this role because it is assigned to users.']);
        }
        return redirect('/admin/roles')->with('success', 'Role deleted successfully!');
    }
}
