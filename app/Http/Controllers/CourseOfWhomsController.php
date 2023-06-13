<?php

namespace App\Http\Controllers;

use App\Models\CourseOfWhoms;
use Illuminate\Http\Request;

class CourseOfWhomsController extends Controller
{
    //
    public function index()
    {
        $courseOfWhoms = CourseOfWhoms::all();

        return response()->json(['courseOfWhoms' => $courseOfWhoms]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required',
        ]);

        $courseOfWhom = CourseOfWhoms::create([
            'course_id' => $request->input('course_id'),
            'title' => $request->input('title'),
        ]);

        return response()->json(['message' => 'Course of Whom created successfully', 'courseOfWhom' => $courseOfWhom]);
    }

    
}
