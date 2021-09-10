<?php

namespace App\Http\Controllers\HospitalPharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\HospitalPharmacy\RegistrationRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use PDF;
use File;
use Storage;

class RegistrationController extends Controller
{
    public function registrationForm(){
        return view('hospital-pharmacy.registration');
    }

    public function registrationSubmit(RegistrationRequest $request){
        dd($request->all());
    }
}
