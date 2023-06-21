<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $allowedRoles = [1, 2, 3, 4]; // Adjust the allowed role IDs according to your role hierarchy

            if (in_array(Auth::user()->role_id, $allowedRoles)) {
                return $next($request);
            } else {
                return redirect('/dashboard')->with('message', 'You do not have permission to access this page');
            }
        } else {
            return redirect('login')->with('message', 'Login first');
        }
    }
}


