<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Feature\CreateRequest;
use App\Http\Requests\Admin\Feature\UpdateRequest;
use App\Repositories\Feature\FeatureRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class FeatureController
 * 
 * Handles the management of feature for permissions.
 */
class FeatureController extends Controller
{
    /**
     * @var FeatureRepositoryInterface
     */
    private FeatureRepositoryInterface $featureRepository;

    /**
     * FeatureController constructor.
     *
     * @param FeatureRepositoryInterface $featureRepository
     */
    public function __construct(FeatureRepositoryInterface $featureRepository)
    {
        $this->middleware('permission:read,features')->only('index');
        $this->middleware('permission:create,features')->only(['create', 'store']);
        $this->middleware('permission:delete,features')->only('destroy');
        $this->featureRepository = $featureRepository;
    }

    /**
     * Display a list of all features.
     * 
     * @return View
     */
    public function index(): View
    {
        $features = $this->featureRepository->index();
        return view('admin.feature.index', [
            'features' => $features
        ]);
    }

    /**
     * Show the form for creating a new feature.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.feature.create');
    }

    /**
     * Store a newly created feature in the database.
     *
     * @param CreateRequest $request The request containing the feature data.
     * @return RedirectResponse A redirect response to the features index page with a success message.
     */
    public function store(CreateRequest $request): RedirectResponse
    {
        $this->featureRepository->store($request->feature_name);
        return redirect('/admin/features')->with('success', 'Feature created successfully!');
    }

    /**
     * Show the form for editing the specified feature.
     *
     * @param integer $id The ID of the feature to edit.
     * @return View The view displaying the feature editing form.
     */
    public function edit(int $id): View
    {
        $feature = $this->featureRepository->show($id);
        return view('admin.feature.edit', [
            'feature' => $feature
        ]);
    }

    /**
     * Update the specified feature in the database.
     *
     * @param UpdateRequest $request The request object containing the new feature data.
     * @param integer $id The ID of the feature to update.
     * @return RedirectResponse Redirects back to the feature list with a success message.
     */
    public function update(UpdateRequest $request, int $id): RedirectResponse
    {
        $this->featureRepository->update($request->feature_name, $id);
        return redirect('/admin/features')->with('success', 'Feature updated successfully!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $exitPermissions = $this->featureRepository->destroy($id);
        if ($exitPermissions) {
            return redirect()->back()->withErrors(['message' => 'This feature is linked to permissions!']);
        }
        return redirect()->back()->with('success', 'Feature deleted successfully!');
    }
}
