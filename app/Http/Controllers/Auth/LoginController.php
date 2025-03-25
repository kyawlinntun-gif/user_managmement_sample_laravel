<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;

/**
 * Class LoginController
 * 
 * Handles user authentication (login and logout).
 */
class LoginController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * LoginController constructor.
     *
     * @param AuthService $authService The authentication service instance.
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Show the login form.
     *
     * @return View The login view.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle user login
     *
     * @param LoginRequest $request The validated login request.
     * @return RedirectResponse Redirects to home on success or back with errors on failure.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        if ($this->authService->login($request->email, $request->password)) {
            return redirect('/');
        }
        return redirect()->back()->withInput($request->except('password'))
            ->withErrors(['message' => 'Invalid credentials or inactive account.']);
    }

    /**
     * Log the user out and redirect to the login page.
     *
     * @return RedirectResponse Redirects the user to the login page after logout.
     */
    public function logout(): RedirectResponse
    {
        $this->authService->logout();
        return redirect('/login');
    }
}
