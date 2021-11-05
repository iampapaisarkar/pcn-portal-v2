<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
use App\Models\OtherRegistration;
use App\Models\Renewal;

class ManufacturingInfo
{
    public static function canSubmitRegistration(){

        $registration = Registration::where(['user_id' => Auth::user()->id, 'type' => 'manufacturing_premises'])
        ->with('other_registration')->latest()->first();

        if($registration){
            if($registration->status == 'facility_no_recommendation'){
                return $response = [
                    'success' => true,
                ];
            }else{
                return $response = [
                    'success' => false,
                    'message' => 'PHARMACEUTICAL MANUFACTURING PREMISES REGISTRATION ALREADY SUBMITTED',
                ];
            }
        }else{
            return $response = [
                'success' => true,
            ];
        }
    }

    public static function status(){

        $registration = Registration::where(['user_id' => Auth::user()->id, 'type' => 'manufacturing_premises'])
        ->with('other_registration')->latest()->first();

        if($registration){
            if($registration->status == 'send_to_registry'){
                return $response = [
                    'success' => true,
                    'message' => 'Inspection Pending',
                    'color' => 'warning',
                ];
            }
            if($registration->status == 'send_to_inspection_monitoring_registration'){
                return $response = [
                    'success' => true,
                    'message' => 'Inspection Pending',
                    'color' => 'warning',
                ];
            }
            if($registration->status == 'send_to_inspection_monitoring'){
                return $response = [
                    'success' => true,
                    'message' => 'Inspection Pending',
                    'color' => 'warning',
                ];
            }
            if($registration->status == 'facility_no_recommendation'){
                return $response = [
                    'success' => true,
                    'message' => 'Not Recommended for Licensure',
                    'color' => 'danger',
                    'new-link' => route('manufacturing-registration-form'),
                    'download-link' => route('location-inspection-report-download', $registration->id),
                ];
            }
            if($registration->status == 'facility_full_recommendation'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Licensure',
                    'color' => 'success',
                    'download-link' => route('location-inspection-report-download', $registration->id),
                ];
            }
            if($registration->status == 'facility_send_to_registration'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Facility Registration',
                    'color' => 'success',
                ];
            }
            if($registration->status == 'licence_issued'){
                return $response = [
                    'success' => true,
                    'message' => 'Licence Issued',
                    'color' => 'success',
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
        if($renwal && $renwal->status == 'full_recommendation'){
            return [
                'response' => false
            ];
        }
        if(($renwal && $renwal->status == 'licence_issued') && (date('Y-m-d') < \Carbon\Carbon::createFromFormat('Y-m-d', $renwal->expires_at)->addDays(1)->format('Y-m-d'))){
            return [
                'response' => false,
                'renewal_date' => \Carbon\Carbon::createFromFormat('Y-m-d', $renwal->expires_at)->addDays(1)->format('d M, Y')
            ];
        }
        return [
            'response' => true
        ];
    }
}