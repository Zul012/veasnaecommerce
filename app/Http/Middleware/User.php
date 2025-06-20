<?php

namespace App\Http\Middleware;

use Closure;

class User
{
    public function handle($request, Closure $next)
    {
        if(empty(session('user'))){
            return redirect()->route('login.form');
        }
        else{
            return $next($request);
        }
    }
}
