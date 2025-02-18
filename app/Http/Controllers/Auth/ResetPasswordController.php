<?php

namespace App\Http\Controllers\Auth;

use App\Models\AdminUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\SendResetLinkRequest;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetLink()
    {
        return view('auth.show-reset-form');
    }
    public function sendResetLink(SendResetLinkRequest $request)
    {
        $user = AdminUser::where('email', $request->email)->first();
        $token = Str::random(60);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );
        Mail::to($user->email)->send(new PasswordResetMail($token));
        return back()->with('success', 'Reset link sent to your email.');
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', [
            'token' => $token
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $resetData = DB::table('password_resets')->where('token', $request->token)->first();
        if(!$resetData) {
            return redirect()->back()->withErrors(['message' => 'Invalid or expired token!']);
        }

        $user = AdminUser::where('email', $resetData->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        DB::table('password_resets')->where('email', $resetData->email)->delete();
        return redirect('/login')->with('success', 'Password changed successfully! You can now login.');
    }
}
