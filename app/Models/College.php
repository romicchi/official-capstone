<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{

    use HasFactory;


    protected $table = 'college'; // Name of the colleges table in the database

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

    public function users()
    {
        return $this->hasMany(User::class, 'college_id'); // Assuming 'college_id' is the foreign key in the users table
    }
}

