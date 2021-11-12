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
use App\Models\Renewal;
use App\Http\Services\Checkout;
use App\Http\Services\FileUpload;

class RenewalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $renewals = Renewal::where(['user_id' => Auth::user()->id])->latest()
        ->with('hospital_pharmacy', 'registration', 'user')
        ->get();

        return view('hospital-pharmacy.renewals', compact('renewals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function renew(){

        $registration = Renewal::where('user_id', Auth::user()->id)
        ->with('hospital_pharmacy', 'registration', 'user')
        ->latest()->first();


        if($registration){
            // if(($registration && $registration->status == 'licence_issued') && (date('Y-m-d') > \Carbon\Carbon::createFromFormat('Y-m-d', $registration->expires_at)->addDays(1)->format('Y-m-d'))){
            //     return view('hospital-pharmacy.renew-form', compact('registration'));
            // }else{
            //     return abort(404);
            // }
            if(($registration && $registration->status == 'licence_issued') && (date('Y-m-d') >= \Carbon\Carbon::createFromFormat('Y-m-d', $registration->expires_at)->format('Y-m-d'))){
                return view('hospital-pharmacy.renew-form', compact('registration'));
            }else{
                return abort(404);
            }
        }else{
            return abort(404);
        }
        
    }

    public function renewalSubmit(RegistrationUpdateRequest $request){

        $isRenewal = Renewal::where(['user_id' => Auth::user()->id, 'type' => 'hospital_pharmacy_renewal'])
        ->latest()->first();
        if($isRenewal && ($isRenewal->status == 'send_to_registry' && $isRenewal->status == 'send_to_registration' && $isRenewal->status == 'no_recommendation')){
            return redirect()->route('hospital-renew');
        }

        try {
            DB::beginTransaction();

            if(Registration::where(['user_id' => Auth::user()->id, 'id' => $request->registration_id, 'type' => 'hospital_pharmacy'])->exists()){

                $Registration = Registration::where(['user_id' => Auth::user()->id, 'id' => $request->registration_id, 'type' => 'hospital_pharmacy'])->first();

                if($request->file('passport') != null){
                    if($Registration->hospital_pharmacy->passport == $request->file('passport')->getClientOriginalName()){
                        $passport = $Registration->hospital_pharmacy->passport;
                    }else{
                        $passport = FileUpload::upload($request->file('passport'), $private = false, 'hospital_pharmacy', 'passport');
        
                        // $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        // DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'hospital_pharmacy'. DIRECTORY_SEPARATOR . $Registration->hospital_pharmacy->passport);
                        // File::Delete($path);
                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'public' . 
                        DIRECTORY_SEPARATOR . 'images'. DIRECTORY_SEPARATOR . $Registration->hospital_pharmacy->passport);
                        File::Delete($path);
                    }
                }else{
                    $passport = $Registration->hospital_pharmacy->passport;
                }

                HospitalRegistration::where(['user_id' => Auth::user()->id, 'registration_id' => $request->registration_id])->update([
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

                $previousRenwal = Renewal::where('user_id', Auth::user()->id)->orderBy('renewal_year', 'desc')->first();
                
                if($previousRenwal->inspection_year == \Carbon\Carbon::now()->format('Y')){
                    $renewalStatus = 'send_to_registry';
                    $renewalInspection = true;
                }else{
                    $renewalStatus = 'send_to_registration';
                    $renewalInspection = false;
                }

                if($previousRenwal->recommendation_status == 'partial_recommendation'){
                    $inspectionYear = \Carbon\Carbon::now()->addYears(2)->format('Y');
                }else if($previousRenwal->recommendation_status == 'full_recommendation'){
                    $inspectionYear = \Carbon\Carbon::now()->addYears(5)->format('Y');
                }
                
                $renewal = Renewal::create([
                    'user_id' => Auth::user()->id,
                    'registration_id' => $request->registration_id,
                    'form_id' => $request->hospital_registration_id,
                    'type' => 'hospital_pharmacy_renewal',
                    'renewal_year' => date('Y'),
                    // 'expires_at' => \Carbon\Carbon::now()->format('Y') .'-12-31',
                    'expires_at' => \Carbon\Carbon::now()->addDays(1)->format('Y-m-d'),
                    // 'status' => $previousRenwal->inspection == true ? 'send_to_registration' : 'send_to_registry',
                    // 'inspection' => $previousRenwal->inspection == true ? false : true,
                    'status' => $renewalStatus,
                    'inspection' => $renewalInspection,
                    'inspection_year' => $inspectionYear,
                ]);

                $response = Checkout::checkoutHospitalPharmacyRenewal($application = ['id' => $renewal->id], 'hospital_pharmacy_renewal', $renewalInspection);
            }

            DB::commit();

            if($response['success']){
                return redirect()->route('invoices.show', ['id' => $response['id']])
                ->with('success', 'Renewal Application successfully submitted. Please pay amount for further action');
            }else{
                return back()->with('error','There is something error, please try after some time');
            }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }

    public function renewalEdit($id){

        $registration = Renewal::where('user_id', Auth::user()->id)
        ->where('status', 'no_recommendation')
        ->with('hospital_pharmacy', 'registration', 'user')
        ->latest()->first();

        if($registration){
            return view('hospital-pharmacy.renewal-form-edit', compact('registration'));
        }else{
            return abort(404);
        }
    }

    public function renewalUpdate(RegistrationUpdateRequest $request, $id){

        $isRenewal = Renewal::where(['id' => $id, 'user_id' => Auth::user()->id, 'type' => 'hospital_pharmacy_renewal'])
        ->latest()->first();
        if($isRenewal && $isRenewal->status != 'no_recommendation'){
            return redirect()->route('hospital-renewals');
        }

        try {
            DB::beginTransaction();

            if(Renewal::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => 'hospital_pharmacy_renewal'])->where('status', 'no_recommendation')->exists()){

                $renewal = Renewal::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => 'hospital_pharmacy_renewal'])
                ->where('status', 'no_recommendation')
                ->with('hospital_pharmacy', 'registration', 'user')
                ->first();

                if($request->file('passport') != null){
                    if($renewal->hospital_pharmacy->passport == $request->file('passport')->getClientOriginalName()){
                        $passport = $renewal->hospital_pharmacy->passport;
                    }else{
                        $passport = FileUpload::upload($request->file('passport'), $private = false, 'hospital_pharmacy', 'passport');
        
                        // $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        // DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'hospital_pharmacy'. DIRECTORY_SEPARATOR . $renewal->hospital_pharmacy->passport);
                        // File::Delete($path);

                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'public' . 
                        DIRECTORY_SEPARATOR . 'images'. DIRECTORY_SEPARATOR . $renewal->hospital_pharmacy->passport);
                        File::Delete($path);
                    }
                }else{
                    $passport = $renewal->hospital_pharmacy->passport;
                }

                Renewal::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => 'hospital_pharmacy_renewal'])
                ->where('status', 'no_recommendation')
                ->with('hospital_pharmacy', 'registration', 'user')
                ->update([
                    'status' => 'send_to_pharmacy_practice',
                    'payment' => false,
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

                $response = Checkout::checkoutHospitalPharmacyRenewal($application = ['id' => $renewal->id], 'hospital_pharmacy_renewal');
            }

            DB::commit();

            if($response['success']){
                return redirect()->route('invoices.show', ['id' => $response['id']])
                ->with('success', 'Renewal Application successfully updated. Please pay amount for further action');
            }else{
                return back()->with('error','There is something error, please try after some time');
            }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }
}
