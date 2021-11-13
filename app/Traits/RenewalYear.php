<?php

namespace App\Traits;

trait RenewalYear{
  
    public function renewal_year() {
        return date('Y-m-d');
    }
    public function expires_at() {
        return date('Y-m-d');
    }
    public function check_renewal_date($expires_at) {
        return date('Y-m-d');
    }
    public function renewal_date($expires_at) {
        return date('Y-m-d');
    }


    // public function renewal_year() {
    //     return \Carbon\Carbon::now()->format('Y');
    // }
    // public function expires_at() {
    //     return \Carbon\Carbon::now()->format('Y-m-d');
    // }
    // public function check_renewal_date($expires_at) {
    //     return \Carbon\Carbon::createFromFormat('Y-m-d', $expires_at)->addDays(1)->format('Y-m-d');
    // }
    // public function renewal_date($expires_at) {
    //     return \Carbon\Carbon::createFromFormat('Y-m-d', $expires_at)->addDays(1)->format('d M, Y');
    // }

}