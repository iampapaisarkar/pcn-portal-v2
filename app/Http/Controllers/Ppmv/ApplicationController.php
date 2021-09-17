<?php

namespace App\Http\Controllers\Ppmv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PpmvLocation\PpmvLocationStoreRequest;
use App\Http\Requests\PpmvLocation\PpmvLocationUpdateRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use PDF;
use File;
use Storage;
use App\Models\Registration;
use App\Models\PpmvLocationApplication;
use App\Http\Services\Checkout;
use App\Http\Services\FileUpload;

class ApplicationController extends Controller
{
    public function applicationForm(){
        return view('ppmv.location-application');
    }

    public function applicationSubmit(PpmvLocationStoreRequest $request){
        try {
            DB::beginTransaction();

            $birth_certificate = FileUpload::upload($request->file('birth_certificate'), $private = true, 'ppmv', 'birth_certificate');
            $educational_certificate = FileUpload::upload($request->file('educational_certificate'), $private = true, 'ppmv', 'educational_certificate');
            $income_tax = FileUpload::upload($request->file('income_tax'), $private = true, 'ppmv', 'income_tax');
            $handwritten_certificate = FileUpload::upload($request->file('handwritten_certificate'), $private = true, 'ppmv', 'handwritten_certificate');

            $Registration = Registration::create([
                'user_id' => Auth::user()->id,
                'type' => 'ppmv',
                'category' => 'PPMV',
                'registration_year' => date('Y'),
                'status' => 'send_to_state_office',
            ]);

            PpmvLocationApplication::create([
                'user_id' => Auth::user()->id,
                'registration_id' => $Registration->id,

                'birth_certificate' => $birth_certificate,
                'educational_certificate' => $educational_certificate,
                'income_tax' => $income_tax,
                'handwritten_certificate' => $handwritten_certificate,

                'reference_1_name' => $request->reference_1_name,
                'reference_1_phone' => $request->reference_1_phone,
                'reference_1_email' => $request->reference_1_email,
                'reference_1_address' => $request->reference_1_address,
                'reference_1_letter' => $reference_1_letter,
                'current_annual_licence' => $request->current_annual_licence,
                'reference_2_name' => $request->reference_2_name,
                'reference_2_phone' => $request->reference_2_phone,
                'reference_2_email' => $request->reference_2_email,
                'reference_2_address' => $request->reference_2_address,
                'reference_2_letter' => $reference_2_letter,
                'reference_occupation' => $request->reference_occupation,
            ]);

            $response = Checkout::checkoutPpmvLocation($application = ['id' => $Registration->id], 'ppmv');

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
