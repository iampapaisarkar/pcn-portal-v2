<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use DB;

class Checkout
{
    public static function checkoutHospitalPharmacy($application, $type){

        try {
            DB::beginTransaction();

            $HospitalRegistration = Registration::where(['id' => $application['id'], 'payment' => false, 'type' => $type])->first(); 

            if($HospitalRegistration){
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