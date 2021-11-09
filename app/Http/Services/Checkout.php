<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\ChildService;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use App\Models\OtherRegistration;
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

                $extraService = ServiceFeeMeta::where('id', $HospitalRegistration->bed_capacity)->first();
                $extra_service_id =  $extraService->id;
                $totalAmount += (floatval($extraService->registration_fee) + floatval($extraService->inspection_fee));

                $invoiceCount = Payment::count();
                $token = md5(uniqid(rand(), true));
                // $order_id = date('m-Y') . '-' .rand(10,1000);
                // $order_id = date('m-Y') . '-' .$invoiceCount+1;
                // $order_id = strtotime(date('m-Y')) . '-' . $invoiceCount+1;
                $today = \Carbon\Carbon::today()->format('m-Y');
                $order_id =  (float)($today) . '-' . $invoiceCount+1;

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


    public static function checkoutHospitalPharmacyRenewal($application, $type, $renewalInspection){

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

                $extraService = ServiceFeeMeta::where('id', $HospitalRegistration->bed_capacity)->first();
                $extra_service_id =  $extraService->id;

                if($renewalInspection == true){
                    $totalAmount += (floatval($extraService->registration_fee) + floatval($extraService->inspection_fee));
                }else{
                    $totalAmount += floatval($extraService->registration_fee);
                }

                $invoiceCount = Payment::count();
                $token = md5(uniqid(rand(), true));
                // $order_id = date('m-Y') . '-' .rand(10,1000);
                // $order_id = date('m-Y') . '-' .$invoiceCount+1;
                // $order_id = strtotime(date('m-Y')) . '-' . $invoiceCount+1;
                $today = \Carbon\Carbon::today()->format('m-Y');
                $order_id =  (float)($today) . '-' . $invoiceCount+1;

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

                $invoiceCount = Payment::count();
                $token = md5(uniqid(rand(), true));
                // $order_id = date('m-Y') . '-' . $invoiceCount+1;
                // $order_id = strtotime(date('m-Y')) . '-' . $invoiceCount+1;
                $today = \Carbon\Carbon::today()->format('m-Y');
                $order_id =  (float)($today) . '-' . $invoiceCount+1;

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

                $invoiceCount = Payment::count();
                $token = md5(uniqid(rand(), true));
                // $order_id = date('m-Y') . '-' .rand(10,1000);
                // $order_id = date('m-Y') . '-' .$invoiceCount+1;
                // $order_id = strtotime(date('m-Y')) . '-' . $invoiceCount+1;
                $today = \Carbon\Carbon::today()->format('m-Y');
                $order_id =  (float)($today) . '-' . $invoiceCount+1;

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

                $invoiceCount = Payment::count();
                $token = md5(uniqid(rand(), true));
                // $order_id = date('m-Y') . '-' .rand(10,1000);
                // $order_id = date('m-Y') . '-' .$invoiceCount+1;
                // $order_id = strtotime(date('m-Y')) . '-' . $invoiceCount+1;
                $today = \Carbon\Carbon::today()->format('m-Y');
                $order_id =  (float)($today) . '-' . $invoiceCount+1;

                $payment = Payment::create([
                    'vendor_id' => Auth::user()->id,
                    'order_id' => $order_id,
                    'application_id' => $application['id'],
                    'service_id' => $service->id,
                    'service_type' => 'ppmv_renewal',
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


    public static function checkoutCommunity($application, $type){

        try {
            DB::beginTransaction();

            $Registration = Registration::where(['id' => $application['id'], 'payment' => false, 'type' => $type])->first(); 
            $OtherRegistration = OtherRegistration::where(['registration_id' => $application['id']])->first(); 

            if($Registration){
                $service = ChildService::where('id', 3)
                ->with('netFees')
                ->first();

                $totalAmount = 0;
                foreach($service->netFees as $fee){
                    $totalAmount += $fee->amount;
                }

                $invoiceCount = Payment::count();
                $token = md5(uniqid(rand(), true));
                // $order_id = date('m-Y') . '-' .rand(10,1000);
                // $order_id = date('m-Y') . '-' .$invoiceCount+1;
                // $order_id = strtotime(date('m-Y')) . '-' . $invoiceCount+1;
                $today = \Carbon\Carbon::today()->format('m-Y');
                $order_id =  (float)($today) . '-' . $invoiceCount+1;

                $payment = Payment::create([
                    'vendor_id' => Auth::user()->id,
                    'order_id' => $order_id,
                    'application_id' => $application['id'],
                    'service_id' => $service->id,
                    'service_type' => $type . '_registration',
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

    public static function checkoutDistribution($application, $type){

        try {
            DB::beginTransaction();

            $Registration = Registration::where(['id' => $application['id'], 'payment' => false, 'type' => $type])->with('user.company')->first(); 
            $OtherRegistration = OtherRegistration::where(['registration_id' => $application['id']])->first(); 

            if($Registration){
                $service = ChildService::where('id', 6)
                ->with('netFees')
                ->first();

                $totalAmount = 0;
                foreach($service->netFees as $fee){
                    $totalAmount += $fee->amount;
                }

                $extraService = ServiceFeeMeta::where('id', $Registration->user->company->sub_category)->first();
                $extra_service_id =  $extraService->id;
                $totalAmount += floatval($extraService->location_fee);

                $invoiceCount = Payment::count();
                $token = md5(uniqid(rand(), true));
                // $order_id = date('m-Y') . '-' .rand(10,1000);
                // $order_id = date('m-Y') . '-' .$invoiceCount+1;
                // $order_id = strtotime(date('m-Y')) . '-' . $invoiceCount+1;
                $today = \Carbon\Carbon::today()->format('m-Y');
                $order_id =  (float)($today) . '-' . $invoiceCount+1;

                $payment = Payment::create([
                    'vendor_id' => Auth::user()->id,
                    'order_id' => $order_id,
                    'application_id' => $application['id'],
                    'service_id' => $service->id,
                    'extra_service_id' => $extra_service_id,
                    'service_type' => $type . '_registration',
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


    public static function checkoutCommunityRegistration($application, $type){

        try {
            DB::beginTransaction();

            $Registration = Registration::where(['id' => $application['id'], 'payment' => false, 'type' => $type])->first(); 
            $OtherRegistration = OtherRegistration::where(['registration_id' => $application['id']])->first(); 

            if($Registration){
                $service = ChildService::where('id', 4)
                ->with('netFees')
                ->first();

                $totalAmount = 0;
                foreach($service->netFees as $fee){
                    $totalAmount += $fee->amount;
                }

                $invoiceCount = Payment::count();
                $token = md5(uniqid(rand(), true));
                // $order_id = date('m-Y') . '-' .rand(10,1000);
                // $order_id = date('m-Y') . '-' .$invoiceCount+1;
                // $order_id = strtotime(date('m-Y')) . '-' . $invoiceCount+1;
                $today = \Carbon\Carbon::today()->format('m-Y');
                $order_id =  (float)($today) . '-' . $invoiceCount+1;

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

    public static function checkoutDistributionRegistration($application, $type){

        try {
            DB::beginTransaction();

            $Registration = Registration::where(['id' => $application['id'], 'payment' => false, 'type' => $type])->with('user.company')->first(); 
            $OtherRegistration = OtherRegistration::where(['registration_id' => $application['id']])->first(); 

            if($Registration){
                $service = ChildService::where('id', 7)
                ->with('netFees')
                ->first();

                $totalAmount = 0;
                foreach($service->netFees as $fee){
                    $totalAmount += $fee->amount;
                }

                $extraService = ServiceFeeMeta::where('id', $Registration->user->company->sub_category)->first();
                $extra_service_id =  $extraService->id;
                $totalAmount += (floatval($extraService->registration_fee) + floatval($extraService->inspection_fee));

                $invoiceCount = Payment::count();
                $token = md5(uniqid(rand(), true));
                // $order_id = date('m-Y') . '-' .rand(10,1000);
                // $order_id = date('m-Y') . '-' .$invoiceCount+1;
                // $order_id = strtotime(date('m-Y')) . '-' . $invoiceCount+1;
                $today = \Carbon\Carbon::today()->format('m-Y');
                $order_id =  (float)($today) . '-' . $invoiceCount+1;

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


    public static function checkoutCommunityRenewal($application, $type){

        try {
            DB::beginTransaction();

            $Renewal = Renewal::where(['id' => $application['id'], 'payment' => false, 'type' => $type])->first(); 

            if($Renewal){
                $service = ChildService::where('id', 5)
                ->with('netFees')
                ->first();

                $totalAmount = 0;
                foreach($service->netFees as $fee){
                    $totalAmount += $fee->amount;
                }

                $invoiceCount = Payment::count();
                $token = md5(uniqid(rand(), true));
                // $order_id = date('m-Y') . '-' .rand(10,1000);
                // $order_id = date('m-Y') . '-' .$invoiceCount+1;
                // $order_id = strtotime(date('m-Y')) . '-' . $invoiceCount+1;
                $today = \Carbon\Carbon::today()->format('m-Y');
                $order_id =  (float)($today) . '-' . $invoiceCount+1;

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

    public static function checkoutDistributionRenewal($application, $type){

        try {
            DB::beginTransaction();

            $Renewal = Renewal::where(['id' => $application['id'], 'payment' => false, 'type' => $type])->with('user.company')->first(); 

            if($Renewal){
                $service = ChildService::where('id', 8)
                ->with('netFees')
                ->first();

                $totalAmount = 0;
                foreach($service->netFees as $fee){
                    $totalAmount += $fee->amount;
                }

                $extraService = ServiceFeeMeta::where('id', $Renewal->user->company->sub_category)->first();
                $extra_service_id =  $extraService->id;
                if($Renewal->inspection == true){
                    $totalAmount += floatval($extraService->renewal_fee);
                }else{
                    $totalAmount += (floatval($extraService->renewal_fee) + floatval($extraService->inspection_fee));
                }

                $invoiceCount = Payment::count();
                $token = md5(uniqid(rand(), true));
                // $order_id = date('m-Y') . '-' .rand(10,1000);
                // $order_id = date('m-Y') . '-' .$invoiceCount+1;
                // $order_id = strtotime(date('m-Y')) . '-' . $invoiceCount+1;
                $today = \Carbon\Carbon::today()->format('m-Y');
                $order_id =  (float)($today) . '-' . $invoiceCount+1;

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


    public static function checkoutManufacturing($application, $type){

        try {
            DB::beginTransaction();

            $Registration = Registration::where(['id' => $application['id'], 'payment' => false, 'type' => $type])->with('user.company')->first(); 
            $OtherRegistration = OtherRegistration::where(['registration_id' => $application['id']])->first(); 

            if($Registration){
                $service = ChildService::where('id', 10)
                ->with('netFees')
                ->first();

                $totalAmount = 0;
                foreach($service->netFees as $fee){
                    $totalAmount += $fee->amount;
                }

                $extraService = ServiceFeeMeta::where('id', $Registration->user->company->sub_category)->first();
                $extra_service_id =  $extraService->id;
                $totalAmount += (floatval($extraService->registration_fee) + floatval($extraService->inspection_fee));


                $invoiceCount = Payment::count();
                $token = md5(uniqid(rand(), true));
                // $order_id = date('m-Y') . '-' .rand(10,1000);
                // $order_id = date('m-Y') . '-' .$invoiceCount+1;
                // $order_id = strtotime(date('m-Y')) . '-' . $invoiceCount+1;
                $today = \Carbon\Carbon::today()->format('m-Y');
                $order_id =  (float)($today) . '-' . $invoiceCount+1;

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
    
    public static function checkoutManufacturingRenewal($application, $type){

        try {
            DB::beginTransaction();

            $Renewal = Renewal::where(['id' => $application['id'], 'payment' => false, 'type' => $type])->with('user.company')->first(); 

            if($Renewal){
                $service = ChildService::where('id', 11)
                ->with('netFees')
                ->first();

                $totalAmount = 0;
                foreach($service->netFees as $fee){
                    $totalAmount += $fee->amount;
                }

                $extraService = ServiceFeeMeta::where('id', $Renewal->user->company->sub_category)->first();
                $extra_service_id =  $extraService->id;
                if($Renewal->inspection == true){
                    $totalAmount += floatval($extraService->renewal_fee);
                }else{
                    $totalAmount += (floatval($extraService->renewal_fee) + floatval($extraService->inspection_fee));
                }

                $invoiceCount = Payment::count();
                $token = md5(uniqid(rand(), true));
                // $order_id = date('m-Y') . '-' .rand(10,1000);
                // $order_id = date('m-Y') . '-' .$invoiceCount+1;
                // $order_id = strtotime(date('m-Y')) . '-' . $invoiceCount+1;
                $today = \Carbon\Carbon::today()->format('m-Y');
                $order_id =  (float)($today) . '-' . $invoiceCount+1;

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
}