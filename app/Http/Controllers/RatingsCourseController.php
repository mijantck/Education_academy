<?php

namespace App\Http\Controllers;

use App\Models\RatingsCourse;
use Illuminate\Http\Request;

class RatingsCourseController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'student_id' => 'required',
            'rating' => 'required|between:1,5'
        ]);

        $rating = RatingsCourse::create([
            'course_id' => $request->input('course_id'),
            'student_id' => $request->input('student_id'),
            'rating' => $request->input('rating'),
        ]);

        return response()->json(['message' => 'Rating created successfully']);
    }

    public function getCourseAverageRating($courseId)
    {
        $course = RatingsCourse::find($courseId);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $averageRating = $course->ratings()->average('rating');

        return response()->json(['average_rating' => $averageRating]);
    }

}
