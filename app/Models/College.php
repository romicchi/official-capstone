<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    protected $table = 'college'; // Name of the colleges table in the database

    // Relationship with courses
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}

