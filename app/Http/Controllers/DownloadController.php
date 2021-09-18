<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;
use DB;
use App\Models\PpmvLocationApplication;

class DownloadController extends Controller
{
    public function downloadHospitalInspectionReport(Request $request, $id){

        $registration = Registration::where(['payment' => true, 'id' => $id, 'type' => 'hospital_pharmacy'])
        ->with('hospital_pharmacy', 'user')
        ->first();

        if($registration){
            $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
            DIRECTORY_SEPARATOR . $registration->user_id . DIRECTORY_SEPARATOR . 'hospital_pharmacy' . DIRECTORY_SEPARATOR . $registration->inspection_report);
            return response()->download($path);
        }else{
            return abort(404);
        }
    }


    public function downloadPPMVBirthCertificate(Request $request, $id){
        $application = PpmvLocationApplication::where(['id' => $id])
        ->with('user')
        ->first();
        if($application){
            $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
            DIRECTORY_SEPARATOR . $application->user_id . DIRECTORY_SEPARATOR . 'ppmv' . DIRECTORY_SEPARATOR . $application->birth_certificate);
            return response()->download($path);
        }else{
            return abort(404);
        }
    }

    public function downloadPPMVEducationCertificate(Request $request, $id){
        $application = PpmvLocationApplication::where(['id' => $id])
        ->with('user')
        ->first();
        if($application){
            $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
            DIRECTORY_SEPARATOR . $application->user_id . DIRECTORY_SEPARATOR . 'ppmv' . DIRECTORY_SEPARATOR . $application->educational_certificate);
            return response()->download($path);
        }else{
            return abort(404);
        }
    }

    public function downloadPPMVIncomeTaxCertificate(Request $request, $id){
        $application = PpmvLocationApplication::where(['id' => $id])
        ->with('user')
        ->first();
        if($application){
            $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
            DIRECTORY_SEPARATOR . $application->user_id . DIRECTORY_SEPARATOR . 'ppmv' . DIRECTORY_SEPARATOR . $application->income_tax);
            return response()->download($path);
        }else{
            return abort(404);
        }
    }

    public function downloadPPMVHandwrittenCertificate(Request $request, $id){
        $application = PpmvLocationApplication::where(['id' => $id])
        ->with('user')
        ->first();
        if($application){
            $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
            DIRECTORY_SEPARATOR . $application->user_id . DIRECTORY_SEPARATOR . 'ppmv' . DIRECTORY_SEPARATOR . $application->handwritten_certificate);
            return response()->download($path);
        }else{
            return abort(404);
        }
    }

    public function downloadPPMVReferenceLetter1(Request $request, $id){
        $application = PpmvLocationApplication::where(['id' => $id])
        ->with('user')
        ->first();
        if($application){
            $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
            DIRECTORY_SEPARATOR . $application->user_id . DIRECTORY_SEPARATOR . 'ppmv' . DIRECTORY_SEPARATOR . $application->reference_1_letter);
            return response()->download($path);
        }else{
            return abort(404);
        }
    }

    public function downloadPPMVReferenceLetter2(Request $request, $id){
        $application = PpmvLocationApplication::where(['id' => $id])
        ->with('user')
        ->first();
        if($application){
            $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
            DIRECTORY_SEPARATOR . $application->user_id . DIRECTORY_SEPARATOR . 'ppmv' . DIRECTORY_SEPARATOR . $application->reference_2_letter);
            return response()->download($path);
        }else{
            return abort(404);
        }
    }

    public function downloadPPMVLocationInspectionReport(Request $request, $id){
        $application = Registration::where(['payment' => true, 'id' => $id, 'type' => 'ppmv'])
        ->with('ppmv', 'user')
        ->first();

        if($application){
            $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
            DIRECTORY_SEPARATOR . $application->user_id . DIRECTORY_SEPARATOR . 'ppmv' . DIRECTORY_SEPARATOR . $application->inspection_report);
            return response()->download($path);
        }else{
            return abort(404);
        }
    }

    public function downloadPPMVRegistrationInspectionReport(Request $request, $id){
        $application = Registration::where(['payment' => true, 'id' => $id, 'type' => 'ppmv'])
        ->with('ppmv', 'user')
        ->first();

        if($application){
            $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
            DIRECTORY_SEPARATOR . $application->user_id . DIRECTORY_SEPARATOR . 'ppmv' . DIRECTORY_SEPARATOR . $application->inspection_report);
            return response()->download($path);
        }else{
            return abort(404);
        }
    }
}
