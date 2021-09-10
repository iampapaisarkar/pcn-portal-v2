<?php

namespace App\Http\Controllers\PharmacyPractice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PPMVApplication;
use App\Models\PPMVRenewal;
use App\Http\Services\AllActivity;
use App\Http\Services\FileUpload;
use DB;

class PPMVApplicationController extends Controller
{
    public function reports(Request $request){
        

        $applications = PPMVRenewal::where('payment', true)
        ->where('inspection', true)
        ->where(function($q){
            $q->where('status', 'recommended');
            $q->orWhere('status', 'unrecommended');
        })
        ->with('user', 'ppmv_application', 'meptp_application');

        if($request->per_page){
            $perPage = (integer) $request->per_page;
        }else{
            $perPage = 10;
        }

        if(!empty($request->search)){
            $search = $request->search;
            $applications = $applications->whereHas('user', function($q) use ($search){
                $q->where('firstname', 'like', '%' .$search. '%');
                $q->orWhere('lastname', 'like', '%' .$search. '%');
            })
            ->orWhereHas('meptp_application', function($q) use ($search){
                $q->where('shop_name', 'like', '%' .$search. '%');
            });
        }

        $applications = $applications->latest()->paginate($perPage);

        return view('pharmacypractice.ppmv.report.ppmv-reports', compact('applications'));
    }


    public function show($id){

        $application = PPMVRenewal::where('id', $id)
        ->where('inspection', true)
        ->where('payment', true)
        ->where(function($q){
            $q->where('status', 'recommended');
            $q->orWhere('status', 'unrecommended');
        })
        ->with('user', 'ppmv_application', 'meptp_application')
        ->first();

        if($application){
            return view('pharmacypractice.ppmv.report.ppmv-report-show', compact('application'));
        }else{
            return abort(404);
        }
    }


    public function downloadReport($id){

        $application = PPMVRenewal::where('id', $id)->first();

        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
        DIRECTORY_SEPARATOR . $application->vendor_id . DIRECTORY_SEPARATOR . 'PPMV' . DIRECTORY_SEPARATOR . $application->inspection_report);
        return response()->download($path);
        
    }
}
