<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course_q_a extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'question',
        'ans',
    ];

    public function course()
    {
        return $this->belongsTo(Courses::class);
    }
}
