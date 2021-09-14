<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;
use DB;

class DownloadController extends Controller
{
    public function downloadHospitalInspectionReport(Request $request, $id){

        $registration = Registration::where(['payment' => true, 'id' => $id, 'type' => 'hospital_pharmacy'])
        ->with('hospital_pharmacy', 'user')
        // ->where(function($q){
        //     $q->where('status', 'no_recommendation');
        //     $q->orWhere('status', 'partial_recommendation');
        //     $q->orWhere('status', 'full_recommendation');
        // })
        ->first();

        if($registration){
            $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
            DIRECTORY_SEPARATOR . $registration->user_id . DIRECTORY_SEPARATOR . 'hospital_pharmacy' . DIRECTORY_SEPARATOR . $registration->inspection_report);
            return response()->download($path);
        }else{
            return abort(404);
        }
    }
}
