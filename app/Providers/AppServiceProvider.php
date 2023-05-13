<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider; // added by cirera
use Illuminate\Support\Facades\View;
use App\Models\Channel; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
 
        //View::share('channels', Channel::all()); 
        
        //comment if you want to run migrate in a new environment
    }
}
