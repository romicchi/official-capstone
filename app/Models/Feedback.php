<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'title', 'content', 'category_id'];

    protected $table = 'feedbacks';

    public function category()
    {
        return $this->belongsTo(FeedbackCategory::class, 'category_id');
    }
}
