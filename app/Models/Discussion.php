<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'slug',
        'channel_id',
        'course_id',
    ];

    public function author() 
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)->with('owner');
    }

    // Laravel will find the discussion using the slug in the database
    public function getRouteKeyName() {
        return 'slug';
    }
    
    // To filter each discussion by Channels
    public function scopeFilterByChannels($builder) {
        if(request()->query('channel')) {
            $channel = Channel::where('slug', request()->query('channel'))->first(); 

            if($channel) {
                return $builder->where('channel_id', $channel->id);
            }
            return $builder;
        }
        return $builder;
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

}
