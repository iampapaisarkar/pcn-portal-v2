<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckProfileStatus
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
        if (auth()->user()->hasRole(['hospital_pharmacy'])
        || auth()->user()->hasRole(['community_pharmacy'])
        || auth()->user()->hasRole(['distribution_premisis'])
        || auth()->user()->hasRole(['manufacturing_premisis'])
        || auth()->user()->hasRole(['ppmv'])
        ) {
            if(auth()->user()->address && auth()->user()->state && auth()->user()->lga && auth()->user()->dob){
                return $next($request);
            }
            return redirect('profile')->with('status','Please update your profile to perform further action');
        }else{
            return $next($request);
        }
    }
}
