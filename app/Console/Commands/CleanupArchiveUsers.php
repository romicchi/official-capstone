<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\ArchiveUser;

class CleanupArchiveUsers extends Command
{
    protected $signature = 'cleanup:archive_users';
    protected $description = 'Delete old records from archive_users table';

    public function handle()
    {
        $sixMonthsAgo = Carbon::now()->subMonths(6);

        ArchiveUser::where('archived_at', '<', $sixMonthsAgo)->delete();

        $this->info('Old records from archive_users table have been deleted.');
    }
}

