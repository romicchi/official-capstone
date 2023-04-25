<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->last_activity = now();
            $user->save();

            $sessionLifetime = config('auth.lifetime');
            $now = now();

            if ($now->diffInMinutes($user->last_activity) > $sessionLifetime) {
                $user->update(['last_activity' => $now]); // update last activity time before logging out
                Auth::logout();
                return redirect('/login')->with('message', 'Your session has expired. Please login again.');
            }

            Auth::user()->update(['last_activity' => $now]);
        }

        return parent::handle($request, $next, ...$guards);
    }
}
