<?php

namespace App\Http\Controllers;

use App\Models\CourseComment;
use Illuminate\Http\Request;

class CourseCommentController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'student_id' => 'required',
            'comments' => 'required',
        ]);

        $comment = CourseComment::create($request->all());

        return response()->json(['comment' => $comment], 201);
    }

    public function index(Request $request)
    {
        $courseId = $request->query('course_id');

        $comments = CourseComment::when($courseId, function ($query) use ($courseId) {
            $query->where('course_id', $courseId);
        })->with('student')->get();

        return response()->json(['comments' => $comments]);
    }

    public function show(CourseComment $comment)
    {
        return response()->json(['comment' => $comment]);
    }

    public function update(Request $request, CourseComment $comment)
    {
        $request->validate([
            'comments' => 'required',
        ]);

        $comment->update($request->all());

        return response()->json(['comment' => $comment]);
    }

    public function destroy(CourseComment $comment)
    {
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
