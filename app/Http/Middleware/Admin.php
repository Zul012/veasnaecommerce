<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        if($request->user()->role=='admin'){
            return $next($request);
        }
        else{
            session()->flash('error', 'You do not have any permission to access this page');
            return redirect()->route($request->user()->role);
        }
    }
}
