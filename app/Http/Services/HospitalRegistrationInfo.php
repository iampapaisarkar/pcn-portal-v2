<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
use App\Models\HospitalRegistration;

class HospitalRegistrationInfo
{

    public static function canSubmitHospitalRegistration(){
        $HospitalRegistration = HospitalRegistration::where(['user_id' => Auth::user()->id])
        ->latest()->first();

        if($HospitalRegistration){
            return $response = [
                'success' => false,
                'message' => 'HOSPITAL REFISTRATION ALREADY SUBMITED',
            ];
        }else{
            return $response = [
                'success' => true,
            ];
        }
    }

    public static function status(){
        $HospitalRegistration = Registration::where(['user_id' => Auth::user()->id, 'payment' => true, 'type' => 'hospital_pharmacy'])
        ->with('hospital_pharmacy')->latest()->first();

        if($HospitalRegistration){
            if($HospitalRegistration->status == 'send_to_state_office')
            return $response = [
                'success' => true,
                'message' => 'Document Verification Pending',
            ];
        }else{
            return $response = [
                'success' => false,
            ];
        }
    }
}