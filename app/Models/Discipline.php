<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    protected $table = 'disciplines'; // Name of the table in the database

    protected $fillable = ['name']; // Fillable attributes

    // Relationship with colleges
    public function colleges()
    {
        return $this->belongsToMany(College::class, 'discipline_Name', 'discipline_id', 'college_id');
    }
}
