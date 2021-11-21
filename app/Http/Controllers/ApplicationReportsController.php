<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\ChildService;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use App\Models\OtherRegistration;
use App\Models\Renewal;
use DB;

class ApplicationReportsController extends Controller
{
    public function report(){
        return view('generate-application-report');
    }


    public function generateReport(Request $request){
        return view('generate-application-report');
    }
}
