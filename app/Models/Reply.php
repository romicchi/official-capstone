<?php

namespace App\Models;


class Reply extends Model
{
    // Define relationship
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function discussion() {
        return $this->belongsTo(Discussion::class);
    }
}
