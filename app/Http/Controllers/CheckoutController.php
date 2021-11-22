<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use App\Models\Renewal;

use App\Models\Service;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use DB;
use App\Jobs\EmailSendJOB;

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

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'hospital_pharmacy', 'facility_inspection', 'paid', Auth::user()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'hospital_pharmacy',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            if($order->service_type == 'hospital_pharmacy_renewal'){
                Renewal::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'hospital_pharmacy_renewal'])->update([
                    'payment' => true
                ]);

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'hospital_pharmacy', 'renewal_inspection', 'paid', Auth::user()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'hospital_pharmacy_renewal',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            if($order->service_type == 'ppmv'){
                Registration::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'ppmv'])->update([
                    'payment' => true
                ]);

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'ppmv', 'location_inspection', 'paid', Auth::user()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'ppmv',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            if($order->service_type == 'ppmv_banner'){
                Registration::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'ppmv'])->update([
                    'payment' => true,
                    'banner_status' => 'paid'
                ]);

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'ppmv', 'location_approval_banner', 'paid', Auth::user()->state);
                \App\Http\Services\Reports::storeApplicationReport($registration->application_id, 'ppmv', 'location_approval_banner', 'approved', Auth::user()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'ppmv_banner',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            if($order->service_type == 'ppmv_registration'){
                Registration::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'ppmv'])->update([
                    'payment' => true
                ]);

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'ppmv', 'facility_inspection', 'paid', Auth::user()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'ppmv_registration',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            if($order->service_type == 'ppmv_renewal'){
                Renewal::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'ppmv_renewal'])->update([
                    'payment' => true
                ]);

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'ppmv', 'renewal_inspection', 'paid', Auth::user()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'ppmv_renewal',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            if($order->service_type == 'community_pharmacy'){
                Registration::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'community_pharmacy'])->update([
                    'payment' => true
                ]);

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'community_pharmacy', 'location_inspection', 'paid', Auth::user()->company()->first()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'community_pharmacy',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            if($order->service_type == 'community_pharmacy_banner'){
                Registration::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'community_pharmacy'])->update([
                    'payment' => true,
                    'banner_status' => 'paid'
                ]);

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'community_pharmacy', 'location_approval_banner', 'paid', Auth::user()->company()->first()->state);
                \App\Http\Services\Reports::storeApplicationReport($registration->application_id, 'community_pharmacy', 'location_approval_banner', 'approved', Auth::user()->company()->first()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'community_pharmacy_banner',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            if($order->service_type == 'community_pharmacy_renewal'){
                Renewal::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'community_pharmacy_renewal'])->update([
                    'payment' => true
                ]);

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'community_pharmacy', 'renewal_inspection', 'paid', Auth::user()->company()->first()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'community_pharmacy_renewal',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            if($order->service_type == 'distribution_premises'){
                Registration::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'distribution_premises'])->update([
                    'payment' => true
                ]);

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'distribution_premises', 'location_inspection', 'paid', Auth::user()->company()->first()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'distribution_premises',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            if($order->service_type == 'distribution_premises_banner'){
                Registration::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'distribution_premises'])->update([
                    'payment' => true,
                    'banner_status' => 'paid'
                ]);

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'distribution_premises', 'location_approval_banner', 'paid', Auth::user()->company()->first()->state);
                \App\Http\Services\Reports::storeApplicationReport($registration->application_id, 'distribution_premises', 'location_approval_banner', 'approved', Auth::user()->company()->first()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'distribution_premises_banner',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            if($order->service_type == 'community_pharmacy_registration'){
                Registration::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'community_pharmacy'])->update([
                    'payment' => true
                ]);

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'community_pharmacy', 'facility_inspection', 'paid', Auth::user()->company()->first()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'community_pharmacy_registration',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            if($order->service_type == 'distribution_premises_registration'){
                Registration::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'distribution_premises'])->update([
                    'payment' => true
                ]);

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'distribution_premises', 'facility_inspection', 'paid', Auth::user()->company()->first()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'distribution_premises_registration',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            if($order->service_type == 'distribution_premises_renewal'){
                Renewal::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'distribution_premises_renewal'])->update([
                    'payment' => true
                ]);

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'distribution_premises', 'renewal_inspection', 'paid', Auth::user()->company()->first()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'distribution_premises_renewal',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            if($order->service_type == 'manufacturing_premises'){
                Registration::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'manufacturing_premises'])->update([
                    'payment' => true
                ]);

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'manufacturing_premises', 'facility_inspection', 'paid', Auth::user()->company()->first()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'manufacturing_premises',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            if($order->service_type == 'manufacturing_premises_renewal'){
                Renewal::where(['id' => $order->application_id, 'user_id' => Auth::user()->id, 'type' => 'manufacturing_premises_renewal'])->update([
                    'payment' => true
                ]);

                // Store Report 
                \App\Http\Services\Reports::storePaymentReport($order->id, 'manufacturing_premises', 'renewal_inspection', 'paid', Auth::user()->company()->first()->state);

                $data = [
                    'order_id' => $order->order_id,
                    'amount' => $order->amount,
                    'user' => Auth::user(),
                    'registration_type' => 'manufacturing_premises_renewal',
                    'type' => 'payment_success',
                ];
                EmailSendJOB::dispatch($data);
            }

            return view('checkout.success', compact('order'));
        }else{
            return abort(404);
        }
        
    }
}
