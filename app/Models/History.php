<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';

    protected $fillable = ['user_id', 'resource_id'];

    // Enable timestamps
    public $timestamps = true;
}
