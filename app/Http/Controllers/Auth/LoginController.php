<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Strong validation rules
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:100'],
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        // Check if user exists
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'No user found with this email.',
            ])->onlyInput('email');
        }


        // ✅ Try logging in
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            if (auth()->user()->user_type === 'admin') {
                return redirect()->intended('/admin/dashboard')->with('success', 'Welcome back, Admin!');
            }

            return redirect()->intended('/')->with('success', 'Logged in successfully!');
        }


        // ❌ Wrong credentials
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
