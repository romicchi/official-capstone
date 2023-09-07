<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveUser extends Model
{
    use HasFactory;

    protected $table = 'archive_users'; // Specify the correct table name
    protected $fillable = ['firstname', 'lastname', 'email', 'role' , 'url' ,'user_id', 'year_level', 'archived_at'];

}
