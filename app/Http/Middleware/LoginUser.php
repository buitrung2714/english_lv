<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('student_id')) {
            return $next($request);
        }else{
            return redirect('/home');
        }
        
    }
}
