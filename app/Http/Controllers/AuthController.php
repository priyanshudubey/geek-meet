<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        // Validate the input data
        \Log::info('Signup request data:', $request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'mobile' => 'required|string|max:10',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user and save to the database
        $user = new User();
        $user->name = $request->name;
        $user->dob = $request->dob;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Encrypt the password
        $user->save(); // Save the user to the database

        return response()->json(['message' => 'User registered successfully!'], 201);
    }
}
