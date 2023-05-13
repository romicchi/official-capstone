<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Image extends Model
{
    use HasFactory;

    // Define table name
    protected $table = 'schoolid';

    // Define fillable columns
    protected $fillable = [
        'school_id'
    ];
}
