<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class ExpireSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expires inactive user sessions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get all users who have not been active for more than 30 days
        $inactiveUsers = User::where('last_activity', '<', Carbon::now()->subDays(30))->get();
        foreach($inactiveUsers as $user) {
            // Logout the user
            Auth::logout();

        }

        $this->info('Expired inactive sessions.');
    }
}
