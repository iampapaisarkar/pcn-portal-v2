<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LocationRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use PDF;
use File;
use Storage;
use App\Models\Registration;
use App\Models\OtherRegistration;
use App\Http\Services\Checkout;
use App\Http\Services\FileUpload;

class FacilityRegistrationController extends Controller
{
    public function facilityForm(){

        if(Auth::user()->hasRole(['community_pharmacy'])){
            $type = 'community_pharmacy';
        }else if(Auth::user()->hasRole(['distribution_premisis'])){
            $type = 'distribution_premisis';
        }

        $application = Registration::where(['user_id' => Auth::user()->id, 'type' => $type])
        ->where(function($q){
            $q->where('status', 'facility_no_recommendation');
            $q->orWhere('status', 'inspection_approved');
        })
        ->with('other_registration', 'user')
        ->latest()->first();

        return view('facility-registration-form', compact('application'));
    }

    public function facilityFormSubmit(LocationRequest $request, $id){
        try {
            DB::beginTransaction();

            if(Auth::user()->hasRole(['community_pharmacy'])){
                $type = 'community_pharmacy';
                $category = 'Community';
            }else if(Auth::user()->hasRole(['distribution_premisis'])){
                $type = 'distribution_premisis';
                $category = 'Distribution';
            }

            $application = Registration::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => $type])
            ->where(function($q){
                $q->where('status', 'facility_no_recommendation');
                $q->orWhere('status', 'inspection_approved');
            })
            ->first();

            if($application){

                Registration::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' =>  $type])
                ->where(function($q){
                    $q->where('status', 'facility_no_recommendation');
                    $q->orWhere('status', 'inspection_approved');
                })
                ->update([
                    'status' => 'send_to_inspection_monitoring_registration',
                    'payment' => false,
                    'location_approval' => false
                ]);

                OtherRegistration::where(['user_id' => Auth::user()->id, 'registration_id' => $id])->update([
                    'firstname' =>$request->firstname,
                    'middlename' => $request->middlename,
                    'surname' => $request->surname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'doq' => $request->doq,
                    'residental_address' => $request->residental_address,
                    'annual_licence_no' => $request->annual_licence_no,
                ]);

                if(Auth::user()->hasRole(['community_pharmacy'])){
                    $response = Checkout::checkoutCommunityRegistration($application = ['id' => $application->id], $type);
                }else if(Auth::user()->hasRole(['distribution_premisis'])){
                    $response = Checkout::checkoutDistributionRegistration($application = ['id' => $application->id], $type);
                }

            }

            DB::commit();

            if($response['success']){
                return redirect()->route('invoices.show', ['id' => $response['id']])
                ->with('success', 'Registration application successfully submitted. Please pay amount for further action');
            }else{
                return back()->with('error','There is something error, please try after some time');
            }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }

    public function facilityStatus(){
        $registration = Registration::where('user_id', Auth::user()->id)->with('other_registration')->latest()->first();
        return view('facility-application-status', compact('registration'));
    }
}
