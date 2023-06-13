<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'url', 'video_id', 'type'];

    public function video()
    {
        return $this->belongsTo(Videos::class);
    }

}
