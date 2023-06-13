<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EnrollStudent;

class Courses extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'preview_url',
        'short_description',
        'language_id',
        'instructor_id',
        'category_id',
        'status',
        'price',
        'full_description',
    ];

    protected $attributes = [
        'status' => 'pending',
        'price' => 0,
        'language_id' => 1, // Set default value for the 'language_id' field
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function languages()
    {
        return $this->belongsTo(languages::class, 'language_id');
    }

    public function couresRequir()
    {
        return $this->hasMany(CourseRequirements::class, 'course_id');
    }
    public function courseOfWhoms()
    {
        return $this->hasMany(CourseOfWhoms::class, 'course_id');
    }

    public function courseQA()
    {
        return $this->hasMany(course_q_a::class, 'course_id');
    }

    public function willLearnCourse()
    {
        return $this->hasMany(WillLearnCourse::class, 'course_id');
    }
    public function ratings()
    {
        return $this->hasMany(RatingsCourse::class, 'course_id');
    }

    public function enrollStudents()
    {
        return $this->hasMany(EnrollStudent::class, 'course_id');
    }
    public function videos()
    {
        return $this->hasMany(Videos::class, 'course_id');
    }

    public function resources()
    {
        return $this->hasManyThrough(Resources::class, Videos::class, 'course_id', 'video_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enroll_students', 'course_id', 'student_id')
            ->withPivot('courses_complete_status')
            ->withTimestamps();
    }
}
