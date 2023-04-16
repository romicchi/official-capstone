<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentTeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher'){
                return $next($request);
                
            } else {
                return redirect('/dashboard')->with('message', 'You do not have permission to access this page');
            }
        } else {
            return redirect('login')->with('message', 'Login first');
        }

    }
}
