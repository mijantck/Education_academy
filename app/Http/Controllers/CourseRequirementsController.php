<?php

namespace App\Http\Controllers;

use App\Models\CourseRequirements;
use Illuminate\Http\Request;

class CourseRequirementsController extends Controller
{
    //
    function store(Request $request){

        $request->validate([
            'title' => 'required',
            'course_id' => 'required',
        ]);
    
        $coureseRequirment = CourseRequirements::create([
            'title' => $request->input('title'),
            'course_id' => $request->input('course_id')

        ]);

        return response()->json(['message' => 'Category created successfully']);
    }


    function index(Request $request,$courseId){

        $courseRequirements = CourseRequirements::where('course_id', $courseId)->get();

        return response()->json(['courseRequirements' => $courseRequirements]);
    }
}
