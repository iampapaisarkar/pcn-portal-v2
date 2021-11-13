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
use App\Models\HospitalRegistration;
use App\Models\Renewal;
use App\Http\Services\Checkout;
use App\Http\Services\FileUpload;
use App\Http\Services\RenewalDates;

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
        ->with('ppmv', 'registration', 'user')
        ->get();

        return view('ppmv.renewals', compact('renewals'));
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
        ->with('ppmv', 'registration', 'user')
        ->latest()->first();


        if($registration){
            // if(($registration && $registration->status == 'licence_issued') && (date('Y-m-d') > \Carbon\Carbon::createFromFormat('Y-m-d', $registration->expires_at)->addDays(1)->format('Y-m-d'))){
            //     return view('ppmv.renew-form', compact('registration'));
            // }else{
            //     return abort(404);
            // }
            if(($registration && $registration->status == 'licence_issued') && (date('Y-m-d') >= \Carbon\Carbon::createFromFormat('Y-m-d', $registration->expires_at)->format('Y-m-d'))){
                return view('ppmv.renew-form', compact('registration'));
            }else{
                return abort(404);
            }
        }else{
            return abort(404);
        }
    }

    public function renewalSubmit(Request $request){

        $isRenewal = Renewal::where(['user_id' => Auth::user()->id, 'type' => 'ppmv_renewal'])
        ->latest()->first();
        if($isRenewal && ($isRenewal->status == 'send_to_registry' || $isRenewal->status == 'send_to_registration' || $isRenewal->status == 'no_recommendation')){
            return redirect()->route('ppmv-renewals.index')->with('error', 'Renewal application already submitted');
        }

        try {
            DB::beginTransaction();

            if(Registration::where(['user_id' => Auth::user()->id, 'id' => $request->registration_id, 'type' => 'ppmv'])->exists()){

                $Registration = Registration::where(['user_id' => Auth::user()->id, 'id' => $request->registration_id, 'type' => 'ppmv'])->first();

                $previousRenwal = Renewal::where('user_id', Auth::user()->id)->orderBy('renewal_year', 'desc')->first();

                $renewal = Renewal::create([
                    'user_id' => Auth::user()->id,
                    'registration_id' => $request->registration_id,
                    'form_id' => $previousRenwal->form_id,
                    'type' => 'ppmv_renewal',
                    'renewal_year' => RenewalDates::renewal_year(),
                    'expires_at' => RenewalDates::expires_at(),
                    'status' => $previousRenwal->inspection == true ? 'send_to_registration' : 'send_to_registry',
                    'inspection' => $previousRenwal->inspection == true ? false : true,
                ]);

                $response = Checkout::checkoutPPMVRenewal($application = ['id' => $renewal->id], 'ppmv_renewal');
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
        ->where('id', $id)
        ->with('ppmv', 'registration', 'user')
        ->latest()->first();


        if($registration){
            return view('ppmv.renewal-form-edit', compact('registration'));
        }else{
            return abort(404);
        }
    }

    public function renewalUpdate(Request $request, $id){

        $isRenewal = Renewal::where(['id' => $id, 'user_id' => Auth::user()->id, 'type' => 'ppmv_renewal'])
        ->latest()->first();
        if($isRenewal && $isRenewal->status != 'no_recommendation'){
            return redirect()->route('ppmv-renewals.index')->with('error', 'Renewal application already submitted');
        }

        try {
            DB::beginTransaction();

            if(Renewal::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => 'ppmv_renewal'])->where('status', 'no_recommendation')->exists()){

                $renewal = Renewal::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => 'ppmv_renewal'])
                ->where('status', 'no_recommendation')
                ->with('ppmv', 'registration', 'user')
                ->first();

                Renewal::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => 'ppmv_renewal'])
                ->where('status', 'no_recommendation')
                ->with('ppmv', 'registration', 'user')
                ->update([
                    'status' => 'send_to_pharmacy_practice',
                    'payment' => false,
                ]);

                $response = Checkout::checkoutPPMVRenewal($application = ['id' => $renewal->id], 'ppmv_renewal');
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
