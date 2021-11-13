<?php

namespace App\Http\Services;
use \Carbon\Carbon;
use DB;

class RenewalDates{
  
    public static function renewal_year() {
        return Carbon::now()->addYears(1)->format('Y');
    }
    public static function expires_at() {
        return Carbon::now()->addDays(1)->format('Y-m-d');
    }
    public static function check_renewal_date($expires_at) {
        return Carbon::createFromFormat('Y-m-d', $expires_at)->format('Y-m-d');
    }
    public static function renewal_date($expires_at) {
        return Carbon::createFromFormat('Y-m-d', $expires_at)->format('d M, Y');
    }
    public static function can_access_renewal_form($registration) {
        if(($registration && $registration->status == 'licence_issued') && (date('Y-m-d') >= Carbon::createFromFormat('Y-m-d', $registration->expires_at)->format('Y-m-d'))){
            return true;
        }else{
            return false;
        }
    }


    // public static function renewal_year() {
    //     return Carbon::now()->format('Y');
    // }
    // public static function expires_at() {
    //     return Carbon::now()->format('Y-m-d');
    // }
    // public static function check_renewal_date($expires_at) {
    //     return Carbon::createFromFormat('Y-m-d', $expires_at)->addDays(1)->format('Y-m-d');
    // }
    // public static function renewal_date($expires_at) {
    //     return Carbon::createFromFormat('Y-m-d', $expires_at)->addDays(1)->format('d M, Y');
    // }
    // public static function can_access_renewal_form($registration) {
    //     if(($registration && $registration->status == 'licence_issued') && (date('Y-m-d') > Carbon::createFromFormat('Y-m-d', $registration->expires_at)->addDays(1)->format('Y-m-d'))){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

}