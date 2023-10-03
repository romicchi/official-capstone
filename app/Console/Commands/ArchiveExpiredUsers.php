<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\ArchiveUser;
use Carbon\Carbon;

class ArchiveExpiredUsers extends Command
{
    protected $signature = 'archive:expired_users';
    protected $description = 'Archive student users whose expiration date has passed';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();

        // Find student users whose expiration date has passed
        $expiredUsers = User::where('role_id', 1)
            ->where('expiration_date', '<=', $now)
            ->get();

        foreach ($expiredUsers as $user) {
            $this->archiveUser($user);
        }

        $this->info('Expired users archived successfully.');
    }

    // Function to archive a user
    private function archiveUser(User $user)
    {
        // Create an archive record
        $archiveUser = new ArchiveUser();
        $archiveUser->student_number = $user->student_number;
        $archiveUser->firstname = $user->firstname;
        $archiveUser->lastname = $user->lastname;
        $archiveUser->email = $user->email;
        $archiveUser->college_id = $user->college_id;
        $archiveUser->user_id = $user->id;

        // Check if the user has the "Student" role (role_id = 1)
        if ($user->role_id === 1) {
            $archiveUser->year_level = $user->year_level; // Add year level
        } else {
            $archiveUser->year_level = null; // Make year_level nullable for other roles
        }

        $archiveUser->role_id = $user->role_id; // Add role ID
        $archiveUser->url = $user->url; // Add URL
        $archiveUser->archived_at = now(); // Add the current date and time
        $archiveUser->save();

        // Delete the original user record
        $user->delete();
    }
}