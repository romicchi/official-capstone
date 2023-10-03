<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['user_id', 'resource_id', 'comment_text'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }}
