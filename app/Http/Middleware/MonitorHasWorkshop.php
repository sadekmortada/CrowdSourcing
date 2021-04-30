<?php

namespace App\Http\Middleware;

use Closure;
use App\Workshop;
use App\Card;
use Illuminate\Support\Facades\Auth;

class MonitorHasWorkshop
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
        $id=$request->route('workshop');
        $workshop=Workshop::find($id)->first();
        
        if($workshop==null || Auth::user()!=$workshop->user){
            return redirect(route('home'))->with('message','Are You Playing ?');
        }
        
        return $next($request);
    }
}
