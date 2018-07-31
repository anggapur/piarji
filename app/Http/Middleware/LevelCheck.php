<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class LevelCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        if(Auth::User()->level !== $role)
            return redirect('error');
        return $next($request);
    }
}
