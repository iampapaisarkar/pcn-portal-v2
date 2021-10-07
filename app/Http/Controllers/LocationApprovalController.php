<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LocationRequest;
// use App\Http\Requests\RegistrationUpdateRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use PDF;
use File;
use Storage;
use App\Models\Registration;
// use App\Models\HospitalRegistration;
use App\Http\Services\Checkout;
use App\Http\Services\FileUpload;

class LocationApprovalController extends Controller
{
    public function locationForm(){
        return view('location-approval-form');
    }

    public function locationFormSubmit(LocationRequest $request){

        dd($request->all());
        return view('location-approval-form');
    }
}
