<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'image',
        'phone_number',
        'address',
        'country',
        'district',
        'status',
    ];

    public function courses()
    {
        return $this->hasMany(Courses::class);
    }

    public function earningHistories()
    {
        return $this->hasMany(EarningHistory::class, 'instructor_id');
    }

    public function getTotalEarnings()
    {
        return $this->earningHistories()->where('status', 'accept')->sum('amount');
    }
}
