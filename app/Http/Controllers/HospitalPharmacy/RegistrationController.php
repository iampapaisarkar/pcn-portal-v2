<?php

namespace App\Http\Controllers\HospitalPharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\HospitalPharmacy\RegistrationRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use PDF;
use File;
use Storage;
use App\Models\HospitalRegistration;
use App\Http\Services\Checkout;
use App\Http\Services\FileUpload;

class RegistrationController extends Controller
{
    public function registrationForm(){
        return view('hospital-pharmacy.registration');
    }

    public function registrationSubmit(RegistrationRequest $request){

        try {
            DB::beginTransaction();

            $passport = FileUpload::upload($request->file('passport'), $private = true, 'hospital_pharmacy', 'passport');

            // Store MEPTP application 
            $application = HospitalRegistration::create([
                'user_id' => Auth::user()->id,
                'registration_year' => date('Y'),
                'bed_capacity' =>$request->bed_capacity,
                'passport' => $passport,
                'pharmacist_name' => $request->pharmacist_name,
                'pharmacist_email' => $request->pharmacist_email,
                'pharmacist_phone' => $request->pharmacist_phone,
                'qualification_year' => $request->qualification_year,
                'registration_no' => $request->registration_no,
                'last_year_licence_no' => $request->last_year_licence_no,
                'residential_address' => $request->residential_address,
                'status' => 'send_to_state_office',
            ]);

            $response = Checkout::checkoutHospitalPharmacy($application = ['id' => $application->id], 'hospital_pharmacy');

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
