<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    public function author() 
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function replies() 
    {
        return $this->hasMany(Reply::class);
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
}
