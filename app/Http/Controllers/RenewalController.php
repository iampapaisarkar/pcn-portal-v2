<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use PDF;
use File;
use Storage;
use App\Models\Registration;
use App\Models\OtherRegistration;
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
        ->with('other_registration', 'registration', 'user')
        ->get();

        return view('renewals', compact('renewals'));
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

    public function renewalForm(){

        $registration = Renewal::where('user_id', Auth::user()->id)
        ->with('other_registration', 'registration', 'user')
        ->orderBy('renewal_year', 'desc')
        ->latest()->first();


        if($registration){
            if(($registration && $registration->status == 'licence_issued') && (date('Y-m-d') > \Carbon\Carbon::createFromFormat('Y-m-d', $registration->expires_at)->addDays(1)->format('Y-m-d'))){
                return view('renewal-form', compact('registration'));
            }else{
                return abort(404);
            }
        }else{
            return abort(404);
        }
    }

    public function renewalFormSubmit(Request $request){
        try {
            DB::beginTransaction();

            if(Auth::user()->hasRole(['community_pharmacy'])){
                $type = 'community_pharmacy';
            }else if(Auth::user()->hasRole(['distribution_premisis'])){
                $type = 'distribution_premisis';
            }

            if(Registration::where(['user_id' => Auth::user()->id, 'id' => $request->registration_id, 'type' => $type])->exists()){

                $Registration = Registration::where(['user_id' => Auth::user()->id, 'id' => $request->registration_id, 'type' => $type])->first();

                $previousRenwal = Renewal::where('user_id', Auth::user()->id)->orderBy('renewal_year', 'desc')->first();

                OtherRegistration::where(['user_id' => Auth::user()->id, 'registration_id' => $request->registration_id])->update([
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

                $renewal = Renewal::create([
                    'user_id' => Auth::user()->id,
                    'registration_id' => $request->registration_id,
                    'form_id' => $previousRenwal->form_id,
                    'type' => $type.'_renewal',
                    'renewal_year' => date('Y'),
                    'expires_at' => \Carbon\Carbon::now()->format('Y') .'-12-31',
                    // 'licence' => 'TEST2021',
                    'status' => $previousRenwal->inspection == true ? 'send_to_registration' : 'send_to_registry',
                    // 'renewal' => true,
                    'inspection' => $previousRenwal->inspection == true ? false : true,
                    // 'payment' => true,
                ]);

                $response = Checkout::checkoutCommunitDistributionRenewal($application = ['id' => $renewal->id], $type.'_renewal');
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


    public function renewalFormEdit($id){

        $registration = Renewal::where('user_id', Auth::user()->id)
        ->where('id', $id)
        ->with('other_registration', 'registration', 'user')
        ->orderBy('renewal_year', 'desc')
        ->latest()->first();

        if($registration){
            return view('renewal-form-edit', compact('registration'));
        }else{
            return abort(404);
        }
    }

    public function renewalFormUpdate(Request $request, $id){
        try {
            DB::beginTransaction();

            if(Auth::user()->hasRole(['community_pharmacy'])){
                $type = 'community_pharmacy';
            }else if(Auth::user()->hasRole(['distribution_premisis'])){
                $type = 'distribution_premisis';
            }

            if(Registration::where(['user_id' => Auth::user()->id, 'id' => $request->registration_id, 'type' => $type])->exists()){

                $Registration = Registration::where(['user_id' => Auth::user()->id, 'id' => $request->registration_id, 'type' => $type])->first();

                $previousRenwal = Renewal::where('user_id', Auth::user()->id)->orderBy('renewal_year', 'desc')->first();

                OtherRegistration::where(['user_id' => Auth::user()->id, 'registration_id' => $request->registration_id])->update([
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


                Renewal::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => $type.'_renewal'])
                ->where('status', 'no_recommendation')
                ->update([
                    'status' => 'send_to_registry',
                    'payment' => false,
                ]);

                $response = Checkout::checkoutCommunitDistributionRenewal($application = ['id' => $id], $type.'_renewal');
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
}