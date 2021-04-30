<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use App\Workshop;
use App\Card;

class ParticipantHasWorkshop
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
        if($workshop==null){
            return redirect(route('home'))->with('message','Are You Playing ?');
        }
        
        foreach($workshop->users as $user)
            if($user->id==Auth::user()->id)
                return $next($request); 

        return redirect(route('home'))->with('message','Are You Playing ?');
    }
}
