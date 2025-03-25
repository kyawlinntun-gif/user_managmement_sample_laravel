<?php

namespace App\Services;

use App\Models\AdminUser;
use Illuminate\Support\Str;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

/**
 * Class AuthService
 * 
 * Handles user authentication
 */
class AuthService
{
    /**
     * Attempt to log in a user with the given credentials.
     *
     * @param string $email The user's email address.
     * @param string $password The user's password.
     * @return boolean Returns true if authentication is successful, false otherwise.
     */
    public function login(string $email, string $password): bool
    {
        return Auth::attempt([
            'email' => $email,
            'password' => $password,
            'is_active' => 1
        ]) ? true : false;
    }

    /**
     * Log the use out.
     *
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
    }

    /**
     * Send a password reset link to the given email.
     *
     * @param string $email The user's email address.
     * @return void
     */
    public function sendResetLink(string $email): void
    {
        $user = AdminUser::where('email', $email)->first();
        $token = Str::random(60);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );
        Mail::to($user->email)->send(new PasswordResetMail($token));
    }

    /**
     * Reset the user's password using the provided token
     *
     * @param string $token The password reset token.
     * @param string $password The new password.
     * @return boolean Returns true if the token is invalid, false otherwise.
     */
    public function resetPassword(string $token, string $password): bool
    {
        $resetData = DB::table('password_resets')->where('token', $token)->first();
        if(!$resetData) {
            return true;
        }

        $user = AdminUser::where('email', $resetData->email)->first();
        $user->password = Hash::make($password);
        $user->save();
        DB::table('password_resets')->where('email', $resetData->email)->delete();
        return false;
    }
}
