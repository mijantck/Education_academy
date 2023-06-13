<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'image',
        'phone_number',
        'password',
        'provider',
        'address',
        'country',
        'district',
        'status',
        'created_at',
    ];


        protected $hidden = [
        'password',
        'remember_token',
    ];



    public function courses()
    {
        return $this->belongsToMany(Courses::class, 'enroll_students', 'student_id', 'course_id')
            ->withPivot('courses_complete_status')
            ->withTimestamps();
    }

}


