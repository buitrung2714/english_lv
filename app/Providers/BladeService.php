<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Auth;
use App\Models\Staff;

class BladeService extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('hasrole',function($expression){
            if (Auth::check()) {
                if (Auth::user()->hasRoles($expression)) {
                    return true;
                }
            }
            return false;
        });
        Blade::if('imper',function(){
            if (session()->has('imper')) {
                return true;
            }
            return false;
        });
    }
}
