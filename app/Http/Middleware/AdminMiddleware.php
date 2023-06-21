<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::check()){
            
            // Roles: student, teacher, and admin.
            if(Auth::user()->role_id == 3){
                return $next($request);
            } else {
                return redirect('/dashboard')->with('message', 'You are not Admin');
            }
        } else {
            
            return redirect('loginform')->with('message', 'Login first');
        }

    }
}
