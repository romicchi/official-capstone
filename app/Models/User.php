<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;




class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    public $timestamps=false; // Added for the admin-user-update

    protected $table = "users"; // table name in database. note: that sometimes the table is not reading in laravel so we will add this.

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'url',
        'password',
        'seen_guide',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    //This part is for the DiscussionsController. Means that user can have many discussions
    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    //This part is for the RepliesController. Means that a user can have many replies
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    // Define the relationship with the Image model
    public function image()
    {
        return $this->hasOne(Image::class);
    }
    
    public function favorites()
    {
        return $this->belongsToMany(Resource::class, 'favorites', 'user_id', 'resource_id');
    }


    // ...

    /**
     * Force the user to logout.
     *
     * @return void
     */
    public function forceLogout()
    {
        Auth::logoutOtherDevices($this->password);
        Auth::logout();
    }

    // ...

}
