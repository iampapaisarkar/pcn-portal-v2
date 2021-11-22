<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
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

class RegistrationController extends Controller
{
    public function registrationForm(){
        return view('manufacturingpremises.registration-form');
    }

    public function registrationSubmit(LocationRequest $request){

        $isRegistration = Registration::where(['user_id' => Auth::user()->id, 'type' => 'manufacturing_premises'])
        ->with('other_registration')->latest()->first();

        if($isRegistration && $isRegistration->status != 'facility_no_recommendation'){
            return redirect()->route('manufacturing-registration-form');
        }

        try {
            DB::beginTransaction();

            $Registration = Registration::create([
                'user_id' => Auth::user()->id,
                'type' => 'manufacturing_premises',
                'category' => 'Manucaturing',
                'registration_year' => date('Y'),
                'status' => 'send_to_state_office',
                'location_approval' => false
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

            $response = Checkout::checkoutManufacturing($application = ['id' => $Registration->id], 'manufacturing_premises');

            // Store Report 
            \App\Http\Services\Reports::storeApplicationReport($Registration->id, 'manufacturing_premises', 'document_review', 'pending', Auth::user()->company()->first()->state);

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

    public function registrationStatus(){

        $registration = Registration::where('user_id', Auth::user()->id)->latest()->first();
        return view('manufacturingpremises.registration-status', compact('registration'));
    }

    public function registrationEdit($id){

        $application = Registration::where('user_id', Auth::user()->id)
        ->where('status', 'queried_by_state_office')
        ->with('other_registration', 'user')
        ->latest()->first();

        if($application){
            return view('manufacturingpremises.registration-form-edit', compact('application'));
        }else{
            return abort(404);
        }
    }

    public function registrationUpdate(LocationRequest $request, $id){


        $isRegistration = Registration::where(['id' => $id, 'user_id' => Auth::user()->id, 'type' => 'manufacturing_premises'])
        ->with('other_registration')->latest()->first();

        if($isRegistration && $isRegistration->status != 'queried_by_state_office'){
            return redirect()->route('manufacturing-registration-status');
        }

        try {
            DB::beginTransaction();

            if(Registration::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => 'manufacturing_premises', 'status' => 'queried_by_state_office'])->exists()){

                Registration::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' =>  'manufacturing_premises', 'status' => 'queried_by_state_office'])->update([
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

            return redirect()->route('manufacturing-registration-status')
            ->with('success', 'Application successfully updated.');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }
}
