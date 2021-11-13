<?php

namespace App\Traits;

trait RenewalYear{
  
    public function renewal_year() {
        return \Carbon\Carbon::now()->addYears(1)->format('Y');
    }
    public function expires_at() {
        return \Carbon\Carbon::now()->addDays(1)->format('Y-m-d');
    }
    public function check_renewal_date($expires_at) {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $expires_at)->format('Y-m-d');
    }
    public function renewal_date($expires_at) {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $expires_at)->format('d M, Y');
    }


   

}