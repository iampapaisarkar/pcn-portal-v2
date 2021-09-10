<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use App\Models\MEPTPApplication;
use App\Models\PPMVApplication;
use App\Models\PPMVRenewal;
use DB;

class Checkout
{
    public static function checkoutMEPTP($application, $type){

        try {
            DB::beginTransaction();

            if($type == 'meptp'){

                $meptp = MEPTPApplication::where(['id' => $application['id'], 'payment' => false])->first(); 
                // $meptp = MEPTPApplication::where(['id' => $application['id'], 'payment' => true])->first(); // should removethis field

                if($meptp){
                    $service = Service::where('id', 1)
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
                        'service_type' => 'meptp_training',
                        'amount' => $totalAmount,
                        'token' => $token,
                        // 'status' => true // should removethis field
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
            }

            if($type == 'ppmv_registration'){

                $ppmv = PPMVApplication::where(['id' => $application['id']])->first();

                if($ppmv){
                    $service = Service::where('id', 2)
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
                        'service_type' => 'ppmv_registration',
                        'amount' => $totalAmount,
                        'token' => $token,
                        // 'status' => true // should removethis field
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
            }

            if($type == 'ppmv_renewal'){

                $ppmv = PPMVRenewal::where(['id' => $application['id']])->first();

                if($ppmv){
                    $service = Service::where('id', 3)
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
                        'service_type' => 'ppmv_renewal',
                        'amount' => $totalAmount,
                        'token' => $token,
                        // 'status' => true // should removethis field
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
            }

            DB::commit();

            return $response;

        }catch(Exception $e) {
            DB::rollback();
            return ['success' => false];
        }  
    }


}