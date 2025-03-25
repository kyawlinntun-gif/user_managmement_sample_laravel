<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permission\CreateRequest;
use App\Http\Requests\Admin\Permission\UpdateRequest;
use App\Repositories\Feature\FeatureRepositoryInterface;
use App\Repositories\Permission\PermissionRepositoryInterface;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class PermissionController
 * 
 * Handles the management of permission for roles.
 */
class PermissionController extends Controller
{
    /**
     * @var PermissionRepositoryInterface
     */
    private PermissionRepositoryInterface $permissionRepository;
    /**
     * @var FeatureRepositoryInterface
     */
    private FeatureRepositoryInterface $featureRepository;

    /**
     * PermissionController constructor
     *
     * @param PermissionRepositoryInterface $permissionRepository The permission repository for managing permissions
     * @param FeatureRepositoryInterface $featureRepository The feature repository for managing features
     */
    public function __construct(PermissionRepositoryInterface $permissionRepository, FeatureRepositoryInterface $featureRepository)
    {
        $this->middleware('permission:read,permissions')->only('index');
        $this->middleware('permission:create,permissions')->only(['create', 'store']);
        $this->middleware('permission:update,permissions')->only(['edit', 'update']);
        $this->middleware('permission:delete,permissions')->only('destroy');
        $this->permissionRepository = $permissionRepository;
        $this->featureRepository = $featureRepository;
    }

    /**
     * Display a list of permissions with their associated features.
     *
     * @return View The view displaying the list of permissions and their associated features.
     */
    public function index(): View
    {
        $permissions = $this->permissionRepository->getPermissionWithFeature();
        return view('admin.permission.index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Display the form to cresate a new permission.
     *
     * @return View
     */
    public function create(): View
    {
        $features = $this->featureRepository->index();
        return view('admin.permission.create', [
            'features' => $features
        ]);
    }

    /**
     * Handles the request to store a new permission.
     *
     * @param CreateRequest $request The validated request containing permission data.
     * @return RedirectResponse Redirects back with an error if the permission exists, othewise redirects to the permissions list with success.
     */
    public function store(CreateRequest $request): RedirectResponse
    {
        $exists = $this->permissionRepository->checkFeatureExistInPermission($request->permission_name, $request->feature_id);
        if ($exists) {
            return redirect()->back()->withInput($request->all())
                ->withErrors(['message' => 'Permission already exists!']);
        }
        $this->permissionRepository->store($request->permission_name, $request->feature_id);
        return redirect('/admin/permissions')->with('success', 'Permission created successfully!');
    }

    /**
     * Shwo the form for editing a specific permission
     *
     * @param integer $id The ID of the permission.
     * @return View The view for editing the permission.
     */
    public function edit(int $id): View
    {
        $permission = $this->permissionRepository->show($id);
        $features = $this->featureRepository->index();
        return view('admin.permission.edit', [
            'permission' => $permission,
            'features' => $features
        ]);
    }

    /**
     * Update the specified permission
     *
     * @param UpdateRequest $request The validated request containing the updated permission data. 
     * @param integer $id The ID of the permission to update.
     * @return RedirectResponse A redirect response with a success message if the update was successful.
     */
    public function update(UpdateRequest $request, int $id): RedirectResponse
    {
        $exists = $this->permissionRepository->checkPemissionExistById($request->permission_name, $request->feature_id, $id);
        if ($exists) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors(['message' => 'Permission already exists!']);
        }
        $this->permissionRepository->update($request->permission_name, $request->feature_id, $id);
        return redirect('/admin/permissions')->with('success', 'Permission updated successfully!');
    }

    /**
     * Delete the specified permission
     *
     * @param integer $id The ID of the permission to delete.
     * @return RedirectResponse Redirects back with a success or error message.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException if the permission is not found.
     */
    public function destroy(int $id): RedirectResponse
    {
        $checkRoleExistInPermission = $this->permissionRepository->destroy($id);
        if ($checkRoleExistInPermission) {
            return redirect()->back()->withErrors(['message' => 'Cannot delete: Permission is assigned to a role!']);
        }
        return redirect()->back()->with('success', 'Permission deleted successfully!');
    }
}
