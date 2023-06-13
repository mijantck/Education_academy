<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;
use Illuminate\Support\Facades\DB;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = Courses::with('category', 'instructor', 'languages', 'couresRequir', 'courseOfWhoms', 'courseQA', 'willLearnCourse')->get();

        // Add average_rating field to each course
        $courses = $courses->map(function ($course) {
            $averageRating = round($course->ratings()->average('rating'), 2);
            $totalRating = $course->ratings()->count();
            $totalEnrolledStudents = $course->enrollStudents()->count();

            return $course->setAttribute('average_rating', $averageRating)
                ->setAttribute('total_enrolled_students', $totalEnrolledStudents)
                ->setAttribute('rating_count', $totalRating);
        });


        return response()->json(['courses' => $courses]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image', // Added image validation rule
            'short_description' => 'required',
            'instructor_id' => 'required',
            'category_id' => 'required',
            // Add validation rules for other fields as needed
        ]);

        try {
            $imagePath = $request->file('image')->store('images', 'public'); // Store image in the 'images' directory within the 'public' disk
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to upload image', 'error' => $e->getMessage()], 500);
        }

        $course = Courses::create([
            'name' => $request->input('name'),
            'image' => $imagePath, // Use the stored image path
            'preview_url' => '',
            'short_description' => $request->input('short_description'),
            'instructor_id' => $request->input('instructor_id'),
            'category_id' => $request->input('category_id'),
            'status' => 'incomplited',
            'price' => '0',
            'full_description' => '',
            // Assign other fields accordingly
        ]);

        return response()->json(['message' => 'Course created', 'course' => $course]);
    }




    public function updateShortDetails(Request $request, $id)
    {

        $course = Courses::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image',
            'short_description' => 'required',
            'instructor_id' => 'required',
            'category_id' => 'required',
            // Add validation rules for other fields as needed
        ]);

        if ($request->hasFile('image')) {
            try {
                $imagePath = $request->file('image')->store('images', 'public');
                $course->image = $imagePath;
            } catch (\Exception $e) {
                return response()->json(['message' => 'Failed to upload image', 'error' => $e->getMessage()], 500);
            }
        }

        $course->name = $request->input('name');
        $course->preview_url = $request->input('preview_url');
        $course->short_description = $request->input('short_description');
        $course->instructor_id = $request->input('instructor_id');
        $course->category_id = $request->input('category_id');
        // Update other fields accordingly

        $course->save();

        return response()->json(['message' => 'Course updated', 'course' => $course]);
    }



    public function updateFullDetails(Request $request, $id)
    {

        $course = Courses::findOrFail($id);

        $request->validate([
            'preview_url' => 'nullable|url',
            'price' => 'nullable|integer', // Allow nullable and integer validation for the price field
            'full_description' => 'nullable',
            'language_id' => 'nullable|exists:languages,id', // Allow nullable and validate existence in the languages table for language_id field
            // Add validation rules for other fields as needed
        ]);


        $course->preview_url = $request->input('preview_url');
        $course->status = 'pending';
        $course->price = $request->input('price');
        $course->full_description = $request->input('full_description');
        $course->language_id = $request->input('language_id');

        $course->save();

        return response()->json(['message' => 'Course updated', 'course' => $course]);
    }

    public function show($id)
    {
        $course = Courses::with('category', 'instructor', 'languages', 'couresRequir', 'courseOfWhoms', 'courseQA', 'willLearnCourse')
            ->findOrFail($id);

        $averageRating = round($course->ratings()->average('rating'), 2);
        $totalRating = $course->ratings()->count();
        $totalEnrolledStudents = $course->enrollStudents()->count();
        $totalVideos = $course->videos()->count();
        $totalResources = $course->resources()->count();


        $course->setAttribute('average_rating', $averageRating)
            ->setAttribute('total_enrolled_students', $totalEnrolledStudents)
            ->setAttribute('rating_count', $totalRating)
            ->setAttribute('total_videos', $totalVideos)
            ->setAttribute('total_resources', $totalResources);

        return response()->json(['course' => $course]);
    }

    public function getEnrolledStudents(Courses $course)
    {
        $enrolledStudents = DB::table('enroll_students')
            ->where('course_id', $course->id)
            ->join('students', 'enroll_students.student_id', '=', 'students.id')
            ->select('enroll_students.id', 'students.first_name', 'students.last_name', 'students.email', 'students.image')
            ->get();

        return response()->json(['enrolledStudents' => $enrolledStudents]);
    }



    // searching 
    public function search(Request $request)
    {
        // Get the search query from the request
        $query = $request->query('query');

        // Perform the search using the query
        $courses = Courses::where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->get();

        // Return the search results
        return response()->json(['courses' => $courses]);
    }
}
