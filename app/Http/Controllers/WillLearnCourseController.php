<?php

namespace App\Http\Controllers;

use App\Models\WillLearnCourse;
use Illuminate\Http\Request;

class WillLearnCourseController extends Controller
{
    
    public function index()
    {
        $willLearnCourses = WillLearnCourse::all();

        return response()->json(['willLearnCourses' => $willLearnCourses]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'title' => 'required',
        ]);

        $willLearnCourse = WillLearnCourse::create([
            'course_id' => $request->input('course_id'),
            'title' => $request->input('title'),
        ]);

        return response()->json(['message' => 'Will Learn Course created', 'willLearnCourse' => $willLearnCourse]);
    }

    public function show($id)
    {
        $willLearnCourse = WillLearnCourse::findOrFail($id);

        return response()->json(['willLearnCourse' => $willLearnCourse]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'course_id' => 'required',
            'title' => 'required',
        ]);

        $willLearnCourse = WillLearnCourse::findOrFail($id);
        $willLearnCourse->update([
            'course_id' => $request->input('course_id'),
            'title' => $request->input('title'),
        ]);

        return response()->json(['message' => 'Will Learn Course updated', 'willLearnCourse' => $willLearnCourse]);
    }

    public function destroy($id)
    {
        $willLearnCourse = WillLearnCourse::findOrFail($id);
        $willLearnCourse->delete();

        return response()->json(['message' => 'Will Learn Course deleted']);
    }


}
