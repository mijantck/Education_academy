<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

 

    protected $fillable = ['name','short_description','image'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'categories_tags', 'category_id', 'tags_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Courses::class);
    }
}
