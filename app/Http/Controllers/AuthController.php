<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function signup(Request $request)
{
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'dob' => $request->dob,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Signup successful! Please log in.');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}

public function login(Request $request)
{
    try {
        \Log::info('Login attempt with:', $request->all());

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            \Log::info('Login successful for user:', ['user_id' => Auth::id()]);
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        \Log::warning('Login failed: Invalid credentials', $credentials);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    } catch (\Exception $e) {
        \Log::error('Login error:', ['error' => $e->getMessage()]);

        return back()->withErrors([
            'email' => 'An unexpected error occurred. Please try again.',
        ]);
    }
}


public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'You have been logged out.');
}

}
