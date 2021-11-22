<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LocationRequest;
// use App\Http\Requests\RegistrationUpdateRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use PDF;
use File;
use Storage;
use App\Models\Registration;
use App\Models\Payment;
use App\Models\OtherRegistration;
use App\Http\Services\Checkout;
use App\Http\Services\FileUpload;

class LocationApprovalController extends Controller
{
    public function locationForm(){
        return view('location-approval-form');
    }

    public function locationFormSubmit(LocationRequest $request){

        if(Auth::user()->hasRole(['community_pharmacy'])){
            $type = 'community_pharmacy';
            $category = 'Community';
            $status = 'send_to_state_office';
        }else if(Auth::user()->hasRole(['distribution_premises'])){
            $type = 'distribution_premises';
            $category = 'Distribution';
            $status = 'send_to_state_office';
        }

        $isRegistration = Registration::where(['user_id' => Auth::user()->id, 'type' => $type])
        ->with('other_registration')->latest()->first();

        if($isRegistration && $isRegistration->status != 'no_recommendation'){
            return redirect()->route('location-approval-form');
        }

        try {
            DB::beginTransaction();

            $Registration = Registration::create([
                'user_id' => Auth::user()->id,
                'type' => $type,
                'category' => $category,
                'registration_year' => date('Y'),
                'status' => $status,
                'location_approval' => true
            ]);

            OtherRegistration::create([
                'registration_id' => $Registration->id,
                'company_id' => Auth::user()->company()->first()->id,
                'user_id' => Auth::user()->id,
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
                $response = Checkout::checkoutCommunity($application = ['id' => $Registration->id], $type);
            }else if(Auth::user()->hasRole(['distribution_premises'])){
                $response = Checkout::checkoutDistribution($application = ['id' => $Registration->id], $type);
            }

            // Store Report 
            \App\Http\Services\Reports::storeApplicationReport($Registration->id, $type, 'document_review', 'pending', Auth::user()->company()->first()->state);

            DB::commit();

            if($response['success']){
                return redirect()->route('invoices.show', ['id' => $response['id']])
                ->with('success', 'Application successfully submitted. Please pay amount for further action');
            }else{
                return back()->with('error','There is something error, please try after some time');
            }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }
    }

    public function locationStatus(){

        $registration = Registration::where('user_id', Auth::user()->id)->with('other_registration')->latest()->first();
        return view('location-approval-status', compact('registration'));
    }



    public function locationFormEdit($id){

        $application = Registration::where('user_id', Auth::user()->id)
        ->where('status', 'queried_by_state_office')
        ->with('other_registration', 'user')
        ->latest()->first();

        if($application){
            return view('location-approval-form-edit', compact('application'));
        }else{
            return abort(404);
        }
    }

    public function locationFormUpdate(LocationRequest $request, $id){

        if(Auth::user()->hasRole(['community_pharmacy'])){
            $type = 'community_pharmacy';
            $category = 'Community';
        }else if(Auth::user()->hasRole(['distribution_premises'])){
            $type = 'distribution_premises';
            $category = 'Distribution';
        }

        $isRegistration = Registration::where(['id' => $id, 'user_id' => Auth::user()->id, 'type' => $type])
        ->with('other_registration')->latest()->first();

        if($isRegistration && $isRegistration->status != 'queried_by_state_office'){
            return redirect()->route('location-approval-status');
        }

        try {
            DB::beginTransaction();

            if(Auth::user()->hasRole(['community_pharmacy'])){
                $type = 'community_pharmacy';
                $category = 'Community';
            }else if(Auth::user()->hasRole(['distribution_premises'])){
                $type = 'distribution_premises';
                $category = 'Distribution';
            }

            if(Registration::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => $type, 'status' => 'queried_by_state_office'])->exists()){

                Registration::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' =>  $type, 'status' => 'queried_by_state_office'])->update([
                    'status' => 'send_to_state_office',
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

            }

            DB::commit();

            return redirect()->route('location-approval-status')
            ->with('success', 'Application successfully updated.');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }


    public function bannerPay($id){
        if(Payment::where(['application_id' => $id, 'status' => false])->exists()){
            return redirect()->route('invoices.show', ['id' => Payment::where(['application_id' => $id, 'status' => false])->first()->id])
            ->with('success', 'Application successfully submitted. Please pay amount for further action');
        }else{
            try {
                DB::beginTransaction();

                    if(Auth::user()->hasRole(['community_pharmacy'])){
                        $type = 'community_pharmacy';
                    }else if(Auth::user()->hasRole(['distribution_premises'])){
                        $type = 'distribution_premises';
                    }

                    $registration = Registration::where(['payment' => false, 'id' => $id, 'user_id' => Auth::user()->id, 'type' => $type])
                    ->where('banner_status', 'pending')
                    ->with('other_registration.company')
                    ->first();

                    if($type == 'community_pharmacy'){
                        $response = Checkout::checkoutCommunityBanner($application = ['id' => $registration->id], $type);
                    }
                    if($type == 'distribution_premises'){
                        $response = Checkout::checkoutDistributionBanner($application = ['id' => $registration->id], $type);
                    }

                    // Store Report 
                    \App\Http\Services\Reports::storeApplicationReport($registration->id, $type, 'location_approval_banner', 'pending', $registration->other_registration->company->state);

                DB::commit();

                if($response['success']){
                    return redirect()->route('invoices.show', ['id' => $response['id']])
                    ->with('success', 'Application successfully submitted. Please pay amount for further action');
                }else{
                    return back()->with('error','There is something error, please try after some time');
                }
            }catch(Exception $e) {
                DB::rollback();
                return back()->with('error','There is something error, please try after some time');
            }
        }

    }
}
