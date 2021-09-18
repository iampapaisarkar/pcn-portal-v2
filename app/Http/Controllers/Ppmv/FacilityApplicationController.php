<?php

namespace App\Http\Controllers\Ppmv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use PDF;
use File;
use Storage;
use App\Models\Registration;
use App\Models\PpmvLocationApplication;
use App\Http\Services\Checkout;
use App\Http\Services\FileUpload;

class FacilityApplicationController extends Controller
{
    public function applicationForm(){
        return view('ppmv.facility-application');
    }
}
