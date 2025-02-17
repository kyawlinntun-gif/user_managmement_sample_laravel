<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1])) {
            return redirect('/');
        }
        return redirect()->back()->withInput($request->except('password'))
                                    ->withErrors(['message' => 'Invalid credentials or inactive account.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
