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
        if (auth()->user()->hasRole(['hospital_pharmacy', 'community_pharmacy', 'distribution_premisis', 'manufacturing_premisis', 'ppmv'])) {
            if(auth()->user()->hospital_name && auth()->user()->hospital_address && auth()->user()->state && auth()->user()->lga){
                return $next($request);
            }
            return redirect('profile')->with('status','Please update your profile to perform further action');
        }else{
            return $next($request);
        }
    }
}
