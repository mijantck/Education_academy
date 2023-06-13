<?php

namespace App\Http\Controllers;

use App\Models\Student;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class StudentController extends Controller
{
    public function register(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:students',
            'password' => 'required|min:8',
        ]);

        // Create a new student
        $student = Student::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone_number' => $request->input('phone_number'),
            'provider' => $request->input('provider'),
            'address' => $request->input('address'),
            'country' => $request->input('country'),
            'district' => $request->input('district'),
            'status' => $request->input('status'),
            // Assign other fields accordingly

        ]);

        // Generate a token for the student
        $token = $student->createToken('API Token')->plainTextToken;

        // Return the token as a response
        return response()->json(['token' => $token], 201);
    }

    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the student
        $student = Student::where('email', $request->input('email'))->first();

        if (!$student || !Hash::check($request->input('password'), $student->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Generate a token for the student
        $token = $student->createToken('API Token')->plainTextToken;

        // Return the token as a response
        return response()->json(['token' => $token], 200);
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $student = Auth::user();

        if (!Hash::check($request->current_password, $student->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        $student->password = Hash::make($request->new_password);
        $student->save();

        return response()->json(['message' => 'Password changed successfully'], 200);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }


    public function getUserInfo(Request $request)
    {
        $user = $request->user(); // Retrieve the authenticated user

        return response()->json($user, 200);
    }

    public function getEnrolledCourses($studentId)
    {
        $student = Student::find($studentId);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $enrolledCourses = $student->courses;

        return response()->json(['enrolled_courses' => $enrolledCourses]);
    }
}
