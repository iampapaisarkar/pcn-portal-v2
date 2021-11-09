<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use App\Models\OtherRegistration;
use App\Models\Renewal;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;
use DB;
use PDF;
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

    public function downloadPRegistrationInspectionReport(Request $request, $id){

        // if(Auth::user()->hasRole(['community_pharmacy'])){
        //     $type = 'community_pharmacy';
        // }else if(Auth::user()->hasRole(['distribution_premises'])){
        //     $type = 'distribution_premises';
        // }

        $application = Registration::where(['payment' => true, 'id' => $id])
        ->with('user')
        ->first();

        if($application){
            $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
            DIRECTORY_SEPARATOR . $application->user_id . DIRECTORY_SEPARATOR . 'company' . DIRECTORY_SEPARATOR . $application->inspection_report);
            return response()->download($path);
        }else{
            return abort(404);
        }
    }

    public function downloadLicence($id){

        if(Auth::user()->hasRole(['community_pharmacy'])){
            $type = 'community_pharmacy_renewal';
        }else if(Auth::user()->hasRole(['distribution_premises'])){
            $type = 'distribution_premises_renewal';
        }else if(Auth::user()->hasRole(['manufacturing_premises'])){
            $type = 'manufacturing_premises_renewal';
        }

        if(Renewal::where('user_id',  Auth::user()->id)
        ->where('id',  $id)
        ->where('type', $type)
        ->where('status', 'licence_issued')->exists()){

            $data = Renewal::where('user_id',  Auth::user()->id)
            ->where('id',  $id)
            ->where('status', 'licence_issued')
            ->where('type', $type)
            ->with('registration', 'other_registration.company.company_state', 'other_registration.company.company_lga', 'other_registration.company.business', 'user.user_state', 'user.user_lga')
            ->first();

            $backgroundURL = env('APP_URL') . '/admin/dist-assets/images/licence-bg.jpg';
            $profilePhoto = $data->other_registration->company->business->passport ? env('APP_URL') . '/images/'. $data->other_registration->company->business->passport : env('APP_URL') . '/admin/dist-assets/images/avatar.jpg';

            $pdf = PDF::loadView('pdf.CP-DP-MP-licence', ['data' => $data, 'background' => $backgroundURL, 'photo' => $profilePhoto, 'type' => $type]);
            return $pdf->stream();
        }else{
            return abort(404);
        }
    }
    public function hpDownloadLicence($id){

        if(Renewal::where('user_id',  Auth::user()->id)
        ->where('id',  $id)
        ->where('type', 'hospital_pharmacy_renewal')
        ->where('status', 'licence_issued')->exists()){

            $data = Renewal::where('user_id',  Auth::user()->id)
            ->where('id',  $id)
            ->where('status', 'licence_issued')
            ->where('type', 'hospital_pharmacy_renewal')
            ->with('registration', 'hospital_pharmacy', 'user.user_state', 'user.user_lga')
            ->first();

            $backgroundURL = env('APP_URL') . '/admin/dist-assets/images/licence-bg.jpg';
            // $profilePhoto = Auth::user()->photo ? env('APP_URL') . '/images/'. Auth::user()->photo : env('APP_URL') . '/admin/dist-assets/images/avatar.jpg';
            $profilePhoto = $data->hospital_pharmacy->passport ? env('APP_URL') . '/images/'. $data->hospital_pharmacy->passport : env('APP_URL') . '/admin/dist-assets/images/avatar.jpg';

            $pdf = PDF::loadView('pdf.HP-licence', ['data' => $data, 'background' => $backgroundURL, 'photo' => $profilePhoto]);
            return $pdf->stream();
        }else{
            return abort(404);
        }
    }
    public function ppmvDownloadLicence($id){

        if(Renewal::where('user_id',  Auth::user()->id)
        ->where('id',  $id)
        ->where('type', 'ppmv_renewal')
        ->where('status', 'licence_issued')->exists()){

            $data = Renewal::where('user_id',  Auth::user()->id)
            ->where('id',  $id)
            ->where('status', 'licence_issued')
            ->where('type', 'ppmv_renewal')
            ->with('registration', 'ppmv', 'user.user_state', 'user.user_lga')
            ->first();

            $backgroundURL = env('APP_URL') . '/admin/dist-assets/images/licence-bg.jpg';
            $profilePhoto = Auth::user()->photo ? env('APP_URL') . '/images/'. Auth::user()->photo : env('APP_URL') . '/admin/dist-assets/images/avatar.jpg';

            $pdf = PDF::loadView('pdf.PPMV-licence', ['data' => $data, 'background' => $backgroundURL, 'photo' => $profilePhoto]);
            return $pdf->stream();
        }else{
            return abort(404);
        }
    }

    public function testLicence(){

        // $order_id = strtotime(date('m-Y')) . '-' . (0 + 1);

        // dd($order_id);
        $backgroundURL = env('APP_URL') . '/admin/dist-assets/images/licence-bg.jpg';
        $fontURL = env('APP_URL') . '/admin/dist-assets/fonts/OLD.ttf';
        $profilePhoto = Auth::user()->photo ? env('APP_URL') . '/images/'. Auth::user()->photo : env('APP_URL') . '/admin/dist-assets/images/avatar.jpg';

        $pdf = PDF::loadView('pdf.test', ['background' => $backgroundURL, 'photo' => $profilePhoto, 'fontURL' => $fontURL]);
        return $pdf->stream();
        
    }
}
