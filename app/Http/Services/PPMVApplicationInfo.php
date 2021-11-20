<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
use App\Models\PpmvLocationApplication;
use App\Models\Renewal;
use App\Http\Services\RenewalDates;

class PPMVApplicationInfo
{

    public static function canSubmitPPMVApplication(){
        $ppmv = Registration::where(['user_id' => Auth::user()->id, 'type' => 'ppmv'])
        ->with('ppmv')->latest()->first();

        if($ppmv){
            if($ppmv->status == 'no_recommendation'){
                return $response = [
                    'success' => true,
                ];
            }else{
                return $response = [
                    'success' => false,
                    'message' => 'PPMV LOCATION APPROVAL APPLICATION ALREADY SUBMITTED',
                ];
            }
        }else{
            return $response = [
                'success' => true,
            ];
        }
    }

    public static function status(){
        // $ppmv = Registration::where(['user_id' => Auth::user()->id, 'payment' => true, 'type' => 'ppmv'])
        $ppmv = Registration::where(['user_id' => Auth::user()->id, 'type' => 'ppmv'])
        ->with('ppmv')->latest()->first();

        if($ppmv){
            if($ppmv->status == 'send_to_state_office'){
                return $response = [
                    'success' => true,
                    'message' => 'Document Verification Pending',
                    'color' => 'warning',
                ];
            }
            if($ppmv->status == 'queried_by_state_office'){
                return $response = [
                    'success' => true,
                    'message' => 'Document Verification Queried',
                    'color' => 'danger',
                    'reason' => $ppmv->query,
                    'link' => route('ppmv-application-edit', $ppmv->id)
                ];
            }
            if($ppmv->status == 'send_to_registry'){
                return $response = [
                    'success' => true,
                    'message' => 'Inspection Pending',
                    'color' => 'warning',
                ];
            }
            if($ppmv->status == 'send_to_state_office_inspection'){
                return $response = [
                    'success' => true,
                    'message' => 'Inspection Pending',
                    'color' => 'warning',
                ];
            }
            if($ppmv->status == 'no_recommendation'){
                return $response = [
                    'success' => true,
                    'message' => 'Not Recommended for Licensure',
                    'color' => 'danger',
                    'new-link' => route('ppmv-application-form'),
                    'download-link' => route('ppmv-location-inspection-report-download', $ppmv->id),
                ];
            }
            // if($ppmv->status == 'partial_recommendation'){
            //     return $response = [
            //         'success' => true,
            //         'message' => 'Recommended for Licensure',
            //         'color' => 'success',
            //         'download-link' => route('ppmv-location-inspection-report-download', $ppmv->id),
            //     ];
            // }
            if($ppmv->status == 'full_recommendation'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Licensure',
                    'color' => 'success',
                    'download-link' => route('ppmv-location-inspection-report-download', $ppmv->id),
                ];
            }
            // if($ppmv->status == 'send_to_registration'){
            //     return $response = [
            //         'success' => true,
            //         'message' => 'Recommended for Licensure',
            //         'color' => 'success',
            //     ];
            // }
            // if($ppmv->status == 'licence_issued'){
            //     return $response = [
            //         'success' => true,
            //         'message' => 'Licence Issued ',
            //         'color' => 'success',
            //         'download-licence' => route('ppmv-location-inspection-report-download', $ppmv->id),
            //     ];
            // }
            if($ppmv->status == 'inspection_approved'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Facility Registration',
                    'color' => 'success',
                ];
            }
            if($ppmv->status == 'send_to_state_office_registration'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Facility Registration',
                    'color' => 'success',
                ];
            }
            if($ppmv->status == 'facility_no_recommendation'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Facility Registration',
                    'color' => 'success',
                ];
            }
            if($ppmv->status == 'facility_full_recommendation'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Facility Registration',
                    'color' => 'success',
                ];
            }
            if($ppmv->status == 'facility_inspection_approved'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Facility Registration',
                    'color' => 'success',
                ];
            }
            if($ppmv->status == 'licence_issued'){
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

    public static function canSubmitPPMVFacilityApplication(){
        $ppmv = Registration::where(['user_id' => Auth::user()->id, 'type' => 'ppmv'])
        ->with('ppmv')->latest()->first();

        if($ppmv){
            if($ppmv->status == 'send_to_state_office' || 
            $ppmv->status == 'queried_by_state_office' || 
            $ppmv->status == 'send_to_registry' || 
            $ppmv->status == 'send_to_state_office_inspection' || 
            $ppmv->status == 'no_recommendation' 
            // || 
            // $ppmv->status == 'facility_no_recommendation'
            ){
                return $response = [
                    'success' => false,
                    'message' => 'PPMV LOCATION APPROVAL APPLICATION NOT COMPLETE YET',

                ];
            }
            if(($ppmv->status == 'inspection_approved' && $ppmv->banner_status == 'paid' & $ppmv->payment == true) || $ppmv->status == 'facility_no_recommendation'){
                return $response = [
                    'success' => true,

                ];
            }
            else if(($ppmv->status == 'inspection_approved' && $ppmv->banner_status == 'pending') || $ppmv->status == 'facility_no_recommendation'){
                return $response = [
                    'success' => false,
                    'message' => 'LOCATION BANNER PAYMENT NOT COMPLETE YET',
                ];
            }else{
                return $response = [
                    'success' => false,
                    'message' => 'PPMV FACILITY INSPECTION APPLICATION ALEARY SUBMITTED',
                ];
            }
        }else{
            return $response = [
                'success' => false,
                'message' => 'PPMV LOCATION APPROVAL APPLICATION NOT COMPLETE YET',
            ];
        }
    }

    public static function facilityStatus(){
        // $ppmv = Registration::where(['user_id' => Auth::user()->id, 'payment' => true, 'type' => 'ppmv'])
        $ppmv = Registration::where(['user_id' => Auth::user()->id, 'type' => 'ppmv'])
        ->with('ppmv')->latest()->first();

        if($ppmv){
            if($ppmv->status == 'send_to_state_office_registration'){
                return $response = [
                    'success' => true,
                    'message' => 'Document Verification Pending',
                    'color' => 'warning',
                ];
            }
            if($ppmv->status == 'facility_no_recommendation'){
                return $response = [
                    'success' => true,
                    'message' => 'Not Recommended for Licensure',
                    'color' => 'danger',
                    'new-link' => route('ppmv-facility-application-form'),
                    'download-link' => route('ppmv-registration-inspection-report-download', $ppmv->id),
                ];
            }
            if($ppmv->status == 'facility_full_recommendation'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Licensure',
                    'color' => 'success',
                    'download-link' => route('ppmv-registration-inspection-report-download', $ppmv->id),
                ];
            }
            if($ppmv->status == 'facility_send_to_registration'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Facility Registration',
                    'color' => 'success',
                ];
            }
            if($ppmv->status == 'licence_issued'){
                return $response = [
                    'success' => true,
                    'message' => 'Licence Issued',
                    'color' => 'success',
                ];
            }
            return $response = [
                'success' => false,
            ];
            
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
        if(($renwal && $renwal->status == 'licence_issued') && (date('Y-m-d') < RenewalDates::check_renewal_date($renwal->expires_at))){
            return [
                'response' => false,
                'renewal_date' => RenewalDates::renewal_date($renwal->expires_at)
            ];
        }
        return [
            'response' => true
        ];
    }
}