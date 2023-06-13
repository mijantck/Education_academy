<?php

namespace App\Http\Controllers;



use App\Models\Category;
use App\Models\Course;
use App\Models\Courses;

class HomePageController extends Controller
{

    public function homePage()
    {
        // Get up to 8 categories
        $categories = Category::limit(8)->get();

        // Get up to 6 popular courses based on ratings
        

        // // Add average_rating field to each course
        // $courses = $courses->map(function ($course) {
        //     $averageRating = round($course->ratings()->average('rating'), 2);
        //     $totalRating = $course->ratings()->count();
        //     $totalEnrolledStudents = $course->enrollStudents()->count();

        //     return $course->setAttribute('average_rating', $averageRating);
        // });
        // $popularCourses = Courses::orderByDesc('average_rating')->limit(6)->get();

        // Get courses under each category
        $categories = Category::all();
        $coursesByCategory = [];

        foreach ($categories as $category) {
        $courses = Courses::where('category_id', $category->id)->get();
        $courses = $courses->map(function ($course) {
            $averageRating = round($course->ratings()->average('rating'), 2);
            $totalRating = $course->ratings()->count();
            $totalEnrolledStudents = $course->enrollStudents()->count();

            return $course->setAttribute('average_rating', $averageRating)
                ->setAttribute('total_enrolled_students', $totalEnrolledStudents)
                ->setAttribute('rating_count', $totalRating);
        });
        $coursesByCategory[] = [
            'name' => $category->name,
            'courses' => $courses,
        ];
        }

        // Return the data as a response
        return response()->json([
            'categories' => $categories,
           
            'courses_by_category' => $coursesByCategory
        ]);
    }
}
