<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    protected $table = 'college'; // Name of the colleges table in the database
    protected $with = ['college'];


    // Relationship with courses
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function disciplines()
    {
        return $this->hasMany(Discipline::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class, 'college_id');
    }

    public function college()
    {
        return $this->belongsTo(College::class, 'name', 'collegeName');
    }
}

