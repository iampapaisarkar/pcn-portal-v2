<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use App\Models\Renewal;

class HospitalRegistrationInfo
{

    public static function canSubmitHospitalRegistration(){
        $HospitalRegistration = Registration::where(['user_id' => Auth::user()->id, 'type' => 'hospital_pharmacy'])
        ->with('hospital_pharmacy')->latest()->first();

        if($HospitalRegistration){
            if($HospitalRegistration->status == 'no_recommendation'){
                return $response = [
                    'success' => true,
                ];
            }else{
                return $response = [
                    'success' => false,
                    'message' => 'HOSPITAL PHARMACY REGISTRATION ALREADY SUBMITTED',
                ];
            }
        }else{
            return $response = [
                'success' => true,
            ];
        }
    }

    public static function status(){
        // $HospitalRegistration = Registration::where(['user_id' => Auth::user()->id, 'payment' => true, 'type' => 'hospital_pharmacy'])
        $HospitalRegistration = Registration::where(['user_id' => Auth::user()->id, 'type' => 'hospital_pharmacy'])
        ->with('hospital_pharmacy')->latest()->first();

        if($HospitalRegistration){
            if($HospitalRegistration->status == 'send_to_state_office'){
                return $response = [
                    'success' => true,
                    'message' => 'Document Verification Pending',
                    'color' => 'warning',
                ];
            }
            if($HospitalRegistration->status == 'queried_by_state_office'){
                return $response = [
                    'success' => true,
                    'message' => 'Document Verification Queried',
                    'color' => 'danger',
                    'reason' => $HospitalRegistration->query,
                    'link' => route('hospital-registration-edit', $HospitalRegistration->id)
                ];
            }
            if($HospitalRegistration->status == 'send_to_registry'){
                return $response = [
                    'success' => true,
                    'message' => 'Inspection Pending',
                    'color' => 'warning',
                ];
            }
            if($HospitalRegistration->status == 'send_to_pharmacy_practice'){
                return $response = [
                    'success' => true,
                    'message' => 'Inspection Pending',
                    'color' => 'warning',
                ];
            }
            if($HospitalRegistration->status == 'no_recommendation'){
                return $response = [
                    'success' => true,
                    'message' => 'Not Recommended for Licensure',
                    'color' => 'danger',
                    'new-link' => route('hospital-registration-form'),
                    'download-link' => route('hospital-inspection-report-download', $HospitalRegistration->id),
                ];
            }
            if($HospitalRegistration->status == 'partial_recommendation'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Licensure',
                    'color' => 'success',
                    'download-link' => route('hospital-inspection-report-download', $HospitalRegistration->id),
                ];
            }
            if($HospitalRegistration->status == 'full_recommendation'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Licensure',
                    'color' => 'success',
                    'download-link' => route('hospital-inspection-report-download', $HospitalRegistration->id),
                ];
            }
            if($HospitalRegistration->status == 'send_to_registration'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Licensure',
                    'color' => 'success',
                ];
            }
            if($HospitalRegistration->status == 'licence_issued'){
                return $response = [
                    'success' => true,
                    'message' => 'Licence Issued ',
                    'color' => 'success',
                    // 'download-licence' => route('hospital-inspection-report-download', $HospitalRegistration->id),
                ];
            }
            
        }else{
            return $response = [
                'success' => false,
            ];
        }
    }


    public function canAccessRenewalPage(){
        if(Renewal::where('user_id', Auth::user()->id)
        // ->where('renewal', true)
        ->latest()
        ->first()){
            return $response = [
                'response' => true,
                'color' => 'warning',
                'message' => 'You\'re already submited PPMV registration',
            ]; 
        
        }else{
            return $response = [
                'response' => false,
                'color' => 'warning',
                'message' => 'You don\'t have licence or renwals yet.',
            ];
        }
    }


    public function licenceRenewalYearCheck(){
        // $meptp = Auth::user()->passed_meptp_application()->first();

        $renwal = Renewal::where('user_id', Auth::user()->id)->orderBy('renewal_year', 'desc')->first();

        if($renwal && $renwal->status == 'send_to_registry'){
            return [
                'response' => false
            ];
        }
        if($renwal && $renwal->status == 'send_to_registration'){
            return [
                'response' => false
            ];
        }
        if($renwal && $renwal->status == 'no_recommendation'){
            return [
                'response' => false
            ];
        }
        if($renwal && $renwal->status == 'partial_recommendation'){
            return [
                'response' => false
            ];
        }
        if($renwal && $renwal->status == 'full_recommendation'){
            return [
                'response' => false
            ];
        }
        if(($renwal && $renwal->status == 'licence_issued') && (date('Y-m-d') < config('renewal.check_renewal_date'))){
            return [
                'response' => false,
                'renewal_date' => config('renewal.renewal_date')
            ];
        }
        return [
            'response' => true
        ];
    }
}