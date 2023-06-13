<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoSections extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function videos()
    {
        return $this->hasMany(Videos::class, 'section_id');
    }
}
