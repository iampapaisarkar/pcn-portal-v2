<?php

namespace App\Http\Controllers\Ppmv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use PDF;
use File;
use Storage;
use App\Models\Registration;
use App\Models\PpmvLocationApplication;
use App\Http\Services\Checkout;
use App\Http\Services\FileUpload;

class FacilityApplicationController extends Controller
{
    public function applicationForm(){
        return view('ppmv.facility-application');
    }

    public function applicationFormSubmit(){

        $isRegistration = Registration::where(['user_id' => Auth::user()->id, 'type' => 'ppmv'])
        ->with('other_registration')->latest()->first();

        if($isRegistration && ($isRegistration->status != 'facility_no_recommendation')){
            return redirect()->route('ppmv-facility-application-form');
        }
        
        $application = Registration::where(['payment' => true, 'user_id' => Auth::user()->id, 'type' => 'ppmv'])
        ->with('ppmv', 'user')
        ->where(function($q){
            $q->where('status', 'facility_no_recommendation');
            $q->orWhere('status', 'inspection_approved');
        })
        ->first();

        if($application){
            Registration::where(['payment' => true, 'user_id' => Auth::user()->id, 'type' => 'ppmv'])
            ->with('ppmv', 'user')
            ->where(function($q){
                $q->where('status', 'facility_no_recommendation');
                $q->orWhere('status', 'inspection_approved');
            })
            ->update([
                'status' => 'send_to_state_office_registration',
                'payment' => false,
                'location_approval' => false
            ]);

            $response = Checkout::checkoutPpmvRegistration($application = ['id' => $application->id], 'ppmv');

            if($response['success']){
                return redirect()->route('invoices.show', ['id' => $response['id']])
                ->with('success', 'Registration application successfully submitted. Please pay amount for further action');
            }else{
                return back()->with('error','There is something error, please try after some time');
            }

        }else{
            abort(404);
        }
    }

    public function status(){
        $application = Registration::where('user_id', Auth::user()->id)->latest()->first();
        return view('ppmv.facility-status', compact('application'));
    }
}
