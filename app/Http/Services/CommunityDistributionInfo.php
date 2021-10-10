<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
use App\Models\OtherRegistration;
use App\Models\Renewal;

class CommunityDistributionInfo
{
    public static function canSubmitLocationApplication(){

        if(Auth::user()->hasRole(['community_pharmacy'])){
            $type = 'community_pharmacy';
        }else if(Auth::user()->hasRole(['distribution_premisis'])){
            $type = 'distribution_premisis';
        }

        $registration = Registration::where(['user_id' => Auth::user()->id, 'type' => $type])
        ->with('other_registration')->latest()->first();

        if($registration){
            if($registration->status == 'no_recommendation'){
                return $response = [
                    'success' => true,
                ];
            }else{
                return $response = [
                    'success' => false,
                    'message' => 'LOCATION APPROVAL APPLICATION ALREADY SUBMITTED',
                ];
            }
        }else{
            return $response = [
                'success' => true,
            ];
        }
    }

    public static function status(){

        if(Auth::user()->hasRole(['community_pharmacy'])){
            $type = 'community_pharmacy';
        }else if(Auth::user()->hasRole(['distribution_premisis'])){
            $type = 'distribution_premisis';
        }
        
        $registration = Registration::where(['user_id' => Auth::user()->id, 'type' => $type])
        ->with('other_registration')->latest()->first();

        if($registration){
            if($registration->status == 'send_to_state_office'){
                return $response = [
                    'success' => true,
                    'message' => 'Document Verification Pending',
                    'color' => 'warning',
                ];
            }
            if($registration->status == 'queried_by_state_office'){
                return $response = [
                    'success' => true,
                    'message' => 'Document Verification Queried',
                    'color' => 'danger',
                    'reason' => $registration->query,
                    'link' => route('location-approval-form-edit', $registration->id)
                ];
            }
            if($registration->status == 'send_to_registry'){
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
            if($registration->status == 'no_recommendation'){
                return $response = [
                    'success' => true,
                    'message' => 'Not Recommended for Licensure',
                    'color' => 'danger',
                    'new-link' => route('location-approval-form'),
                    'download-link' => route('location-inspection-report-download', $registration->id),
                ];
            }
            if($registration->status == 'full_recommendation'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Licensure',
                    'color' => 'success',
                    'download-link' => route('location-inspection-report-download', $registration->id),
                ];
            }
            if($registration->status == 'inspection_approved'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Facility Registration',
                    'color' => 'success',
                ];
            }
            if($registration->status == 'send_to_state_office_registration'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Facility Registration',
                    'color' => 'success',
                ];
            }
            if($registration->status == 'facility_no_recommendation'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Facility Registration',
                    'color' => 'success',
                ];
            }
            if($registration->status == 'facility_full_recommendation'){
                return $response = [
                    'success' => true,
                    'message' => 'Recommended for Facility Registration',
                    'color' => 'success',
                ];
            }
            if($registration->status == 'facility_inspection_approved'){
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
}