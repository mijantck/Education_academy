<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Laravel\Sanctum\HasApiTokens;

class AdminController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:8',
        ]);

        $admin = Admin::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $token = $admin->createToken('Admin Token')->plainTextToken;

        return response()->json(['message' => 'Admin registered successfully', 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the student
        $admin = Admin::where('email', $request->input('email'))->first();

        if (! $admin || ! Hash::check($request->input('password'), $admin->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Generate a token for the student
        $token = $admin->createToken('API Token')->plainTextToken;

        // Return the token as a response
        return response()->json(['admin' => $admin, 'token' => $token], 200);
    }


    public function getAdminInfo(Request $request)
    {
        $user = $request->user(); // Retrieve the authenticated user

        return response()->json($user, 200);
    }

}
