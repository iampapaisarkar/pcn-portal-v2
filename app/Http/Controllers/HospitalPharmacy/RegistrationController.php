<?php

namespace App\Http\Controllers\HospitalPharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function registrationForm(){
        return view('hospital-pharmacy.registration');
    }
}
