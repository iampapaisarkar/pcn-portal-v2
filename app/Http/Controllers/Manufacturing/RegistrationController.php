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

        try {
            DB::beginTransaction();

            $Registration = Registration::create([
                'user_id' => Auth::user()->id,
                'type' => 'manufacturing_premises',
                'category' => 'Manucaturing',
                'registration_year' => date('Y'),
                'status' => 'send_to_registry',
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
}