<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reply extends Model
{

    use HasFactory;

    // Define relationship
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function discussion() {
        return $this->belongsTo(Discussion::class);
    }
}
