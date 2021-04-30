<?php

namespace App\Http\Middleware;

use Closure;

class VerifyIsMonitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!auth()->user()->isMonitor()){
            return redirect(route('home'))->with('message','Are You Playing ?');
        }
        return $next($request);
    }
}
