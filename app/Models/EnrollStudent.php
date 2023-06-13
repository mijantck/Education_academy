<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'student_id',
        'courses_complete_status',
    ];

    protected $attributes = [
        'courses_complete_status' => 'inprogress',
    ];

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }


    public function generateEarnings()
    {
        $course = $this->course;
        $instructor = $course->instructor;

        $earningAmount = 0.1 * $course->price; // Assuming the earning is 10% of the course price

        EarningHistory::create([
            'instructor_id' => $instructor->id,
            'course_id' => $course->id,
            'amount' => $earningAmount,
            'status' => 'pending', // Set the initial status as pending
        ]);
    }
}
