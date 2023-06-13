<?php

namespace App\Http\Controllers;

use App\Models\EnrollStudent;
use Illuminate\Http\Request;

class EnrollStudentController extends Controller
{
    //

    public function store(Request $request)
{
    $request->validate([
        'course_id' => 'required',
        'student_id' => 'required',
        'courses_complete_status' => 'required'
    ]);

    $enrollStudent = EnrollStudent::firstOrNew([
        'course_id' => $request->input('course_id'),
        'student_id' => $request->input('student_id'),
    ]);

        
        // $enrollStudent->courses_complete_status = $request->input('courses_complete_status');
        // $enrollStudent->save();



       // $enrollStudent->generateEarnings();



       // return response()->json(['message' => 'Student enrolled in the course successfully']);


    if (!$enrollStudent->exists) {
        $enrollStudent->courses_complete_status = $request->input('courses_complete_status');
        $enrollStudent->save();
        
        $enrollStudent->generateEarnings();


        return response()->json(['message' => 'Student enrolled in the course successfully']);
    }

    return response()->json(['message' => 'Student is already enrolled in this course']);
}


    public function index($studentId){
        $enrolledCourses = EnrollStudent::where('student_id', $studentId)->with('course')->get();

        return response()->json(['enrolled_courses' => $enrolledCourses]);
    }
}
