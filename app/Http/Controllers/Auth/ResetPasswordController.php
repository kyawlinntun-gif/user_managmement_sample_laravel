<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendResetLinkRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;

/**
 * Class RestPasswordController
 * 
 * Handles to reset password for users
 */
class ResetPasswordController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Shwo the form to request a password reset link
     *
     * @return View The view for the reset password form.
     */
    public function showResetLink(): View
    {
        return view('auth.show-reset-form');
    }

    /**
     * Handle the request to send a password reset link to the user's email.
     *
     * @param SendResetLinkRequest $request The request containing the email.
     * @return RedirectResponse A redirect response with a success message.
     */
    public function sendResetLink(SendResetLinkRequest $request): RedirectResponse
    {
        $this->authService->sendResetLink($request->email);
        return back()->with('success', 'Reset link sent to your email.');
    }

    /**
     * Show the password reset form with the given token.
     *
     * @param string $token The password reset token.
     * @return View The view displaying the reset password form.
     */
    public function showResetForm(string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token
        ]);
    }

    /**
     * Handle the password reset process.
     * 
     * Validates the reset token and updates the user's password
     *
     * @param ResetPasswordRequest $request The request containing the reset token and new password.
     * @return RedirectResponse Redirect response indicating success or failure.
     */
    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $resetPassword = $this->authService->resetPassword($request->token, $request->password);
        if ($resetPassword) {
            return redirect()->back()->withErrors(['message' => 'Invalid or expired token!']);
        }
        return redirect('/login')->with('success', 'Password changed successfully! You can now login.');
    }
}
