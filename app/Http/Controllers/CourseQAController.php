<?php

namespace App\Http\Controllers;

use App\Models\course_q_a;
use App\Models\Courses;
use Illuminate\Http\Request;

class CourseQAController extends Controller
{
    //

    // Store a new course Q&A
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'question' => 'required',
            'ans' => 'required',
        ]);

        $courseQA = course_q_a::create([
            'course_id' => $request->input('course_id'),
            'question' => $request->input('question'),
            'ans' => $request->input('ans'),
        ]);

        return response()->json(['message' => 'Course Q&A created', 'courseQA' => $courseQA]);
    }

    // Get all course Q&As for a specific course_id
    public function show($course_id)
    {
        $courseQAs = course_q_a::where('course_id', $course_id)->get();

        return response()->json(['courseQAs' => $courseQAs]);
    }

}
