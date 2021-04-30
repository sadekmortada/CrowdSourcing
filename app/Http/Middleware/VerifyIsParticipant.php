<?php

namespace App\Http\Middleware;

use Closure;
use App\Workshop;

class VerifyIsParticipant
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
        if(!auth()->user()->isParticipant()){
            return redirect(route('home'))->with('message','Are You Playing ?');
        }
        return $next($request);
    }
}
