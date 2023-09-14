<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    protected $table = 'disciplines'; // Name of the table in the database

    protected $fillable = ['name']; // Fillable attributes

    // Relationship with a single college
    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }
}