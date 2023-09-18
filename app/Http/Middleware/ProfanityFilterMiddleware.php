<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfanityFilterMiddleware
{

    protected $profanityList = [
        'pota',
        'yawa',
        'eroy',
        'tangina',
        'puta',
        'bobo',
        'bitch',
        'fuck',
        'shit',
        'asshole',
        'motherfucker',
        'dick',
        'penis',
        'cunt',
        'nigga',
        'whore',
        'cocksucker',
        'pussy',
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();
    
        foreach ($input as $key => $value) {
            if (is_string($value)) {
                foreach ($this->profanityList as $word) {
                    $value = str_ireplace($word, '***', $value); // Replace bad words with ***
                }
                $input[$key] = $value;
            }
        }
    
        $request->merge($input);
    
        return $next($request);
    }
}
