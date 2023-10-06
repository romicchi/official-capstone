<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id', 'college_id', 'discipline_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function discipline()
    {
        return $this->belongsTo(Discipline::class, 'discipline_id');
    }
}
