<?php

namespace App\Http\Controllers\HospitalPharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\HospitalPharmacy\RegistrationRequest;
use App\Http\Requests\HospitalPharmacy\RegistrationUpdateRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use PDF;
use File;
use Storage;
use App\Models\Registration;
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

            $passport = FileUpload::upload($request->file('passport'), $private = false, 'hospital_pharmacy', 'passport');

            $Registration = Registration::create([
                'user_id' => Auth::user()->id,
                'type' => 'hospital_pharmacy',
                'category' => 'Hospital',
                'registration_year' => date('Y'),
                'status' => 'send_to_state_office',
            ]);


            HospitalRegistration::create([
                'registration_id' => $Registration->id,
                'user_id' => Auth::user()->id,
                'bed_capacity' =>$request->bed_capacity,
                'passport' => $passport,
                'pharmacist_name' => $request->pharmacist_name,
                'pharmacist_email' => $request->pharmacist_email,
                'pharmacist_phone' => $request->pharmacist_phone,
                'qualification_year' => $request->qualification_year,
                'registration_no' => $request->registration_no,
                'last_year_licence_no' => $request->last_year_licence_no,
                'residential_address' => $request->residential_address,
            ]);

            $response = Checkout::checkoutHospitalPharmacy($application = ['id' => $Registration->id], 'hospital_pharmacy');

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
        return view('hospital-pharmacy.status', compact('registration'));
    }

    public function registrationEdit($id){

        $registration = Registration::where('user_id', Auth::user()->id)
        ->where('status', 'queried_by_state_office')
        ->with('hospital_pharmacy', 'user')
        ->latest()->first();

        if($registration){
            return view('hospital-pharmacy.registration-edit', compact('registration'));
        }else{
            return abort(404);
        }
    }

    public function registrationUpdate(RegistrationUpdateRequest $request, $id){

        try {
            DB::beginTransaction();

            if(Registration::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => 'hospital_pharmacy'])->exists()){

                $Registration = Registration::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => 'hospital_pharmacy'])->first();

                if($request->file('passport') != null){
                    if($Registration->hospital_pharmacy->passport == $request->file('passport')->getClientOriginalName()){
                        $passport = $Registration->hospital_pharmacy->passport;
                    }else{
                        $passport = FileUpload::upload($request->file('passport'), $private = false, 'hospital_pharmacy', 'passport');
        
                        // $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        // DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'hospital_pharmacy'. DIRECTORY_SEPARATOR . $Registration->hospital_pharmacy->passport);

                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'public' . 
                        DIRECTORY_SEPARATOR . 'images'. DIRECTORY_SEPARATOR . $Registration->hospital_pharmacy->passport);
                        File::Delete($path);
                    }
                }else{
                    $passport = $Registration->hospital_pharmacy->passport;
                }


                Registration::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => 'hospital_pharmacy'])->update([
                    'status' => 'send_to_state_office',
                ]);

                HospitalRegistration::where(['user_id' => Auth::user()->id, 'registration_id' => $id])->update([
                    'bed_capacity' =>$request->bed_capacity,
                    'passport' => $passport,
                    'pharmacist_name' => $request->pharmacist_name,
                    'pharmacist_email' => $request->pharmacist_email,
                    'pharmacist_phone' => $request->pharmacist_phone,
                    'qualification_year' => $request->qualification_year,
                    'registration_no' => $request->registration_no,
                    'last_year_licence_no' => $request->last_year_licence_no,
                    'residential_address' => $request->residential_address,
                ]);

            }

            DB::commit();

            return redirect()->route('hospital-registration-status')
            ->with('success', 'Application successfully updated.');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }

}
