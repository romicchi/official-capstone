<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ActivityLogMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (Auth::check()) {
            $user = Auth::user();
            $activity = $request->route()->getName() === 'logout' ? 'logout' : 'has login';

            // Get the user's previous activity from the session
            $previousActivity = session('user_activity', null);

            // Check if the activity has changed before logging it
            if ($previousActivity !== $activity) {
                // Log the activity
                \DB::table('activity_logs')->insert([
                    'user_id' => $user->id,
                    'activity' => $activity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update the user's previous activity in the session
                session(['user_activity' => $activity]);
            }
        }

        return $response;
    }
}


