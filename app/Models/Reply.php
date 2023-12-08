<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'discussion_id',
    ];

    // Define relationship
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function discussion() {
        return $this->belongsTo(Discussion::class);
    }
}
