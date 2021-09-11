<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;

use App\Models\Service;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use DB;
use App\Jobs\PaymentSuccessEmailJOB;

class CheckoutController extends Controller
{
    public function paymentError($token){

        if(Payment::where('token', $token)->exists()){

            $order = Payment::where('token', $token)
            ->with('user', 'service')->first();

            return view('checkout.error', compact('order'));
        }else{
            return abort(404);
        }
        
    }

    public function paymentSuccess($token, Request $request){

        if(Payment::where('token', $token)->exists()){

            $order = Payment::where('token', $token)
            ->with('user', 'service')->first();

            $reference_id = $request->ref;
            $total_amount = $request->am;
            $service_charge = floatval($request->am - $order->amount);

            Payment::where('token', $token)->update([
                'token' => null,
                'status' => true,
                'reference_id' => $reference_id,
                'total_amount' => $total_amount,
                'service_charge' => $service_charge,
            ]);

            if($order->service_type == 'hospital_pharmacy'){
                Registration::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'hospital_pharmacy'])->update([
                    'payment' => true
                ]);

                // $application = HospitalRegistration::where(['id' => $order->application_id, 'user_id' => Auth::user()->id])->first();

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'type' => 'hospital_pharmacy',
                ];
                PaymentSuccessEmailJOB::dispatch($data);
            }

            return view('checkout.success', compact('order'));
        }else{
            return abort(404);
        }
        
    }
}
