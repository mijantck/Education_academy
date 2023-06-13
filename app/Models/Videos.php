<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'type', 'section_id', 'course_id', 'videos_complete_status','videosType','haveResource'];

    public function resources()
    {
        return $this->hasMany(Resources::class,'video_id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function relatedVideos()
    {
        return $this->hasMany(Videos::class);
    }
}
