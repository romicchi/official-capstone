<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subject'; // Name of the subjects table in the database

    // Relationship with course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
