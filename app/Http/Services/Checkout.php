<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\ChildService;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use App\Models\Renewal;
use DB;

class Checkout
{
    public static function checkoutHospitalPharmacy($application, $type){

        try {
            DB::beginTransaction();

            $Registration = Registration::where(['id' => $application['id'], 'payment' => false, 'type' => $type])->first(); 
            $HospitalRegistration = HospitalRegistration::where(['registration_id' => $application['id']])->first(); 

            if($Registration){
                $service = ChildService::where('id', 1)
                ->with('netFees')
                ->first();

                $totalAmount = 0;
                foreach($service->netFees as $fee){
                    $totalAmount += $fee->amount;
                }

                $extraServices = config('custom.beds');
                $extra_service_id = null;
                foreach ($extraServices as $key => $extraService) {
                    if($HospitalRegistration->bed_capacity == $extraService['id']){
                        $extra_service_id =  $extraService['id'];
                        $totalAmount += (floatval($extraService['registration_fee']) + floatval($extraService['inspection_fee']));
                    }
                }

                $token = md5(uniqid(rand(), true));
                $order_id = date('m-Y') . '-' .rand(10,1000);

                $payment = Payment::create([
                    'vendor_id' => Auth::user()->id,
                    'order_id' => $order_id,
                    'application_id' => $application['id'],
                    'service_id' => $service->id,
                    'extra_service_id' => $extra_service_id,
                    'service_type' => $type,
                    'amount' => $totalAmount,
                    'token' => $token,
                ]);

                $response = [
                    'success' => true,
                    'order_id' => $order_id,
                    'token' => $token,
                    'id' => $payment->id,
                ];

            }else{
                $response = ['success' => false];
            }

            DB::commit();

            return $response;

        }catch(Exception $e) {
            DB::rollback();
            return ['success' => false];
        }  
    }


    public static function checkoutHospitalPharmacyRenewal($application, $type){

        try {
            DB::beginTransaction();

            $Renewal = Renewal::where(['id' => $application['id'], 'payment' => false, 'type' => $type])->first(); 
            // $previousRenwal = Renewal::where('user_id', Auth::user()->id)->orderBy('renewal_year', 'desc')->first();
            $HospitalRegistration = HospitalRegistration::where(['registration_id' => $Renewal['registration_id']])->first(); 

            if($Renewal){
                $service = ChildService::where('id', 2)
                ->with('netFees')
                ->first();

                $totalAmount = 0;
                foreach($service->netFees as $fee){
                    $totalAmount += $fee->amount;
                }


                $extraServices = config('custom.beds');
                $extra_service_id = null;
                foreach ($extraServices as $key => $extraService) {
                    if($HospitalRegistration->bed_capacity == $extraService['id']){
                        $extra_service_id =  $extraService['id'];
                        $totalAmount += (floatval($extraService['registration_fee']) + floatval($extraService['inspection_fee']));
                    }
                }


                $token = md5(uniqid(rand(), true));
                $order_id = date('m-Y') . '-' .rand(10,1000);

                $payment = Payment::create([
                    'vendor_id' => Auth::user()->id,
                    'order_id' => $order_id,
                    'application_id' => $application['id'],
                    'service_id' => $service->id,
                    'extra_service_id' => $extra_service_id,
                    'service_type' => $type,
                    'amount' => $totalAmount,
                    'token' => $token,
                ]);

                $response = [
                    'success' => true,
                    'order_id' => $order_id,
                    'token' => $token,
                    'id' => $payment->id,
                ];

            }else{
                $response = ['success' => false];
            }

            DB::commit();

            return $response;

        }catch(Exception $e) {
            DB::rollback();
            return ['success' => false];
        }  
    }

    public static function checkoutPpmvLocation($application, $type){

        try {
            DB::beginTransaction();

            $Registration = Registration::where(['id' => $application['id'], 'payment' => false, 'type' => $type])->first(); 

            if($Registration){
                $service = ChildService::where('id', 12)
                ->with('netFees')
                ->first();

                $totalAmount = 0;
                foreach($service->netFees as $fee){
                    $totalAmount += $fee->amount;
                }

                $token = md5(uniqid(rand(), true));
                $order_id = date('m-Y') . '-' .rand(10,1000);

                $payment = Payment::create([
                    'vendor_id' => Auth::user()->id,
                    'order_id' => $order_id,
                    'application_id' => $application['id'],
                    'service_id' => $service->id,
                    'service_type' => $type,
                    'amount' => $totalAmount,
                    'token' => $token,
                ]);

                $response = [
                    'success' => true,
                    'order_id' => $order_id,
                    'token' => $token,
                    'id' => $payment->id,
                ];

            }else{
                $response = ['success' => false];
            }

            DB::commit();

            return $response;

        }catch(Exception $e) {
            DB::rollback();
            return ['success' => false];
        }  
    }


    public static function checkoutPpmvRegistration($application, $type){

        try {
            DB::beginTransaction();

            // $Registration = Registration::where(['id' => $application['id'], 'payment' => false, 'type' => $type])->first(); 
            $Registration = Registration::where(['id' => $application['id'], 'type' => $type])->first(); 

            if($Registration){
                $service = ChildService::where('id', 13)
                ->with('netFees')
                ->first();

                $totalAmount = 0;
                foreach($service->netFees as $fee){
                    $totalAmount += $fee->amount;
                }

                $extraServices = config('custom.ppmv-registration-fees');
                $extra_service_amount = 0;
                foreach ($extraServices as $key => $extraService) {
                    $extra_service_amount += $extraService['fee'];
                }

                $token = md5(uniqid(rand(), true));
                $order_id = date('m-Y') . '-' .rand(10,1000);

                $payment = Payment::create([
                    'vendor_id' => Auth::user()->id,
                    'order_id' => $order_id,
                    'application_id' => $application['id'],
                    'service_id' => $service->id,
                    'service_type' => 'ppmv_registration',
                    'amount' => $totalAmount + $extra_service_amount,
                    'token' => $token,
                ]);

                $response = [
                    'success' => true,
                    'order_id' => $order_id,
                    'token' => $token,
                    'id' => $payment->id,
                ];

            }else{
                $response = ['success' => false];
            }

            DB::commit();

            return $response;

        }catch(Exception $e) {
            DB::rollback();
            return ['success' => false];
        }  
    }

    public static function checkoutPPMVRenewal($application, $type){

        try {
            DB::beginTransaction();

            $Renewal = Renewal::where(['id' => $application['id'], 'payment' => false, 'type' => $type])->first(); 

            if($Renewal){
                $service = ChildService::where('id', 14)
                ->with('netFees')
                ->first();

                $totalAmount = 0;
                foreach($service->netFees as $fee){
                    $totalAmount += $fee->amount;
                }

                $extraServices = config('custom.ppmv-registration-fees');
                $extra_service_amount = 0;
                foreach ($extraServices as $key => $extraService) {
                    $extra_service_amount += $extraService['fee'];
                }

                $token = md5(uniqid(rand(), true));
                $order_id = date('m-Y') . '-' .rand(10,1000);

                $payment = Payment::create([
                    'vendor_id' => Auth::user()->id,
                    'order_id' => $order_id,
                    'application_id' => $application['id'],
                    'service_id' => $service->id,
                    'service_type' => 'ppmv_registration',
                    'amount' => $totalAmount + $extra_service_amount,
                    'token' => $token,
                ]);

                $response = [
                    'success' => true,
                    'order_id' => $order_id,
                    'token' => $token,
                    'id' => $payment->id,
                ];

            }else{
                $response = ['success' => false];
            }

            DB::commit();

            return $response;

        }catch(Exception $e) {
            DB::rollback();
            return ['success' => false];
        }  
    }

}