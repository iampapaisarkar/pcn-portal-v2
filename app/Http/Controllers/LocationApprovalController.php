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
use App\Models\OtherRegistration;
use App\Http\Services\Checkout;
use App\Http\Services\FileUpload;

class LocationApprovalController extends Controller
{
    public function locationForm(){
        return view('location-approval-form');
    }

    public function locationFormSubmit(LocationRequest $request){

        try {
            DB::beginTransaction();

            if(Auth::user()->hasRole(['community_pharmacy'])){
                $type = 'community_pharmacy';
                $category = 'Community';
            }else if(Auth::user()->hasRole(['distribution_premisis'])){
                $type = 'distribution_premisis';
                $category = 'Distribution';
            }

            $Registration = Registration::create([
                'user_id' => Auth::user()->id,
                'type' => $type,
                'category' => $category,
                'registration_year' => date('Y'),
                'status' => 'send_to_state_office',
            ]);

            OtherRegistration::create([
                'registration_id' => $Registration->id,
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

            $response = Checkout::checkoutCommunitDistribution($application = ['id' => $Registration->id], $type);

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
}
