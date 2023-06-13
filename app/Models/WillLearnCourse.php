<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WillLearnCourse extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'title'];

    public function course()
    {
        return $this->belongsTo(Courses::class);
    }
}
