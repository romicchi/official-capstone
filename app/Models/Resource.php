<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'title',
        'topic',
        'keywords',
        'author',
        'uploader',
        'publish_date',
        'description',
        'url',
        'college_id',
        'course_id',
        'subject_id',
        'resource_type_id',
        'download_count',
        'view_count',
        'discipline_id',
        'downloadable',
    ];

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function discipline()
    {
        return $this->belongsTo(Discipline::class, 'discipline_id');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'resource_id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function resourceRatings()
    {
        return $this->hasMany(ResourceRating::class);
    }

    public function resourceType()
    {
        return $this->belongsTo(ResourceType::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class);
    }

}
