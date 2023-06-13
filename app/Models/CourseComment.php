<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseComment extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'student_id', 'comments'];

    public function course()
    {
        return $this->belongsTo(Courses::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
