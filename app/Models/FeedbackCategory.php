<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'category_id');
    }
}
