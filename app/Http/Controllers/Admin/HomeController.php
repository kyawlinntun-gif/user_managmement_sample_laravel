<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AllUpdateRequest;
use App\Repositories\AdminUser\AdminUserRepositoryInterface;
use App\Repositories\Feature\FeatureRepositoryInterface;
use App\Repositories\Permission\PermissionRepositoryInterface;
use App\Services\AdminHomeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class HomeController
 * 
 * Handles the admin dashboard operations.
 */
class HomeController extends Controller
{
    /**
     * @var AdminUserRepositoryInterface
     */
    private AdminUserRepositoryInterface $adminUserRepository;
    /**
     * @var FeatureRepositoryInterface
     */
    private FeatureRepositoryInterface $featureRepository;
    /**
     * @var PermissionRepositoryInterface
     */
    private PermissionRepositoryInterface $permissionRepository;
    /**
     * @var AdminHomeService
     */
    private AdminHomeService $adminHomeService;

    /**
     * HomeController constructor.
     *
     * @param AdminUserRepositoryInterface $adminUserRepository The repository for admin users.
     * @param FeatureRepositoryInterface $featureRepository The repository for features.
     * @param PermissionRepositoryInterface $permissionRepository The repository for permissions.
     * @param AdminHomeService $adminHomeService
     */
    public function __construct(AdminUserRepositoryInterface $adminUserRepository, FeatureRepositoryInterface $featureRepository, PermissionRepositoryInterface $permissionRepository, AdminHomeService $adminHomeService)
    {
        $this->adminUserRepository = $adminUserRepository;
        $this->featureRepository = $featureRepository;
        $this->permissionRepository = $permissionRepository;
        $this->adminHomeService = $adminHomeService;
    }

    /**
     * Display the admin dashboard.
     *
     * @return View The admin home view with admin users, features, and permissions.
     */
    public function index(): View
    {
        $adminUsers = $this->adminUserRepository->index();
        $features = $this->featureRepository->index();
        $permissions = $this->permissionRepository->index();
        return view('admin.home', [
            'adminUsers' => $adminUsers,
            'features' => $features,
            'permissions' => $permissions
        ]);
    }

    /**
     * Handle the update of features and permissions.
     *
     * @param AllUpdateRequest $request The request containing features and permissions data.
     * @return RedirectResponse Redirects back with a success message after updating.
     */
    public function allUpdate(AllUpdateRequest $request): RedirectResponse
    {
        $features = $request->has('features') ? $request->get('features') : [];
        $permissions = $request->has('permissions') ? $request->get('permissions') : [];
        $this->adminHomeService->allUpdate($features, $permissions);
        return redirect()->back()->with('success', 'Updated successfully!');
    }
}
