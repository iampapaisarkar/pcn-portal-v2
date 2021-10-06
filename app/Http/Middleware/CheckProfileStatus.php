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
        if (auth()->user()->hasRole(['hospital_pharmacy'])) {
            if(auth()->user()->hospital_name && auth()->user()->hospital_address && auth()->user()->state && auth()->user()->lga){
                return $next($request);
            }
            return redirect('profile')->with('status','Please update your profile to perform further action');
        }else if(auth()->user()->hasRole(['ppmv'])){
            if(auth()->user()->state && 
            auth()->user()->lga &&
            auth()->user()->gender &&
            auth()->user()->address &&
            auth()->user()->dob &&
            auth()->user()->shop_name &&
            auth()->user()->shop_email &&
            auth()->user()->shop_phone &&
            auth()->user()->shop_address &&
            auth()->user()->shop_city
            ){
                return $next($request);
            }
            return redirect('profile')->with('status','Please update your profile to perform further action');
        }else if(auth()->user()->hasRole(['community_pharmacy', 'distribution_premisis', 'manufacturing_premisis'])){

            if(auth()->user()->company()->first()){
                return $next($request);
            }
            return redirect('company-profile')->with('status','Please update your company profile to perform further action');
        }else{
            return $next($request);
        }
    }
}
