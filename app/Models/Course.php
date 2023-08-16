<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course'; // Name of the courses table in the database

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relationship with college
    public function college()
    {
        return $this->belongsTo(College::class);
    }

    // Relationship with subjects
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class, 'course_id');
    }
}
