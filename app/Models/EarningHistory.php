<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EarningHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'course_id',
        'amount',
        'status',
    ];


    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

}
