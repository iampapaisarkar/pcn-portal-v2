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

    public function applicationFormSubmit(PpmvLocationStoreRequest $request){

        try {
            DB::beginTransaction();

            $birth_certificate = FileUpload::upload($request->file('birth_certificate'), $private = true, 'ppmv', 'birth_certificate');
            $educational_certificate = FileUpload::upload($request->file('educational_certificate'), $private = true, 'ppmv', 'educational_certificate');
            $income_tax = FileUpload::upload($request->file('income_tax'), $private = true, 'ppmv', 'income_tax');
            $handwritten_certificate = FileUpload::upload($request->file('handwritten_certificate'), $private = true, 'ppmv', 'handwritten_certificate');
            $reference_1_letter = FileUpload::upload($request->file('reference_1_letter'), $private = true, 'ppmv', 'reference_1_letter');
            $reference_2_letter = FileUpload::upload($request->file('reference_2_letter'), $private = true, 'ppmv', 'reference_2_letter');

            $application = Registration::create([
                'user_id' => Auth::user()->id,
                'type' => 'ppmv',
                'category' => 'PPMV',
                'registration_year' => date('Y'),
                'status' => 'send_to_state_office',
            ]);

            PpmvLocationApplication::create([
                'user_id' => Auth::user()->id,
                'registration_id' => $application->id,

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

            $response = Checkout::checkoutPpmvLocation($application = ['id' => $application->id], 'ppmv');

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

    public function status(){

        $application = Registration::where('user_id', Auth::user()->id)->latest()->first();
        return view('ppmv.status', compact('application'));
    }


    public function applicationEdit($id){

        $application = Registration::where('user_id', Auth::user()->id)
        ->where('status', 'queried_by_state_office')
        ->with('ppmv', 'user')
        ->latest()->first();

        if($application){
            return view('ppmv.location-application-edit', compact('application'));
        }else{
            return abort(404);
        }
    }

    public function applicationUpdate(PpmvLocationUpdateRequest $request, $id){

        // dd(PpmvLocationApplication::where(['user_id' => Auth::user()->id, 'registration_id' => $id])->first());
        try {
            DB::beginTransaction();

            if(Registration::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => 'ppmv'])->exists()){

                $application = Registration::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => 'ppmv'])->first();

                if($request->file('birth_certificate') != null){
                    if($application->ppmv->birth_certificate == $request->file('birth_certificate')->getClientOriginalName()){
                        $birth_certificate = $application->ppmv->birth_certificate;
                    }else{
                        $birth_certificate = FileUpload::upload($request->file('birth_certificate'), $private = false, 'ppmv', 'birth_certificate');
        
                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'ppmv'. DIRECTORY_SEPARATOR . $application->ppmv->birth_certificate);
                        File::Delete($path);
                    }
                }else{
                    $birth_certificate = $application->ppmv->birth_certificate;
                }
                if($request->file('educational_certificate') != null){
                    if($application->ppmv->educational_certificate == $request->file('educational_certificate')->getClientOriginalName()){
                        $educational_certificate = $application->ppmv->educational_certificate;
                    }else{
                        $educational_certificate = FileUpload::upload($request->file('educational_certificate'), $private = false, 'ppmv', 'educational_certificate');
        
                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'ppmv'. DIRECTORY_SEPARATOR . $application->ppmv->educational_certificate);
                        File::Delete($path);
                    }
                }else{
                    $educational_certificate = $application->ppmv->educational_certificate;
                }
                if($request->file('income_tax') != null){
                    if($application->ppmv->income_tax == $request->file('income_tax')->getClientOriginalName()){
                        $income_tax = $application->ppmv->income_tax;
                    }else{
                        $income_tax = FileUpload::upload($request->file('income_tax'), $private = false, 'ppmv', 'income_tax');
        
                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'ppmv'. DIRECTORY_SEPARATOR . $application->ppmv->income_tax);
                        File::Delete($path);
                    }
                }else{
                    $income_tax = $application->ppmv->income_tax;
                }
                if($request->file('handwritten_certificate') != null){
                    if($application->ppmv->handwritten_certificate == $request->file('handwritten_certificate')->getClientOriginalName()){
                        $handwritten_certificate = $application->ppmv->handwritten_certificate;
                    }else{
                        $handwritten_certificate = FileUpload::upload($request->file('handwritten_certificate'), $private = false, 'ppmv', 'handwritten_certificate');
        
                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'ppmv'. DIRECTORY_SEPARATOR . $application->ppmv->handwritten_certificate);
                        File::Delete($path);
                    }
                }else{
                    $handwritten_certificate = $application->ppmv->handwritten_certificate;
                }
                if($request->file('reference_1_letter') != null){
                    if($application->ppmv->reference_1_letter == $request->file('reference_1_letter')->getClientOriginalName()){
                        $reference_1_letter = $application->ppmv->reference_1_letter;
                    }else{
                        $reference_1_letter = FileUpload::upload($request->file('reference_1_letter'), $private = false, 'ppmv', 'reference_1_letter');
        
                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'ppmv'. DIRECTORY_SEPARATOR . $application->ppmv->reference_1_letter);
                        File::Delete($path);
                    }
                }else{
                    $reference_1_letter = $application->ppmv->reference_1_letter;
                }
                if($request->file('reference_2_letter') != null){
                    if($application->ppmv->reference_2_letter == $request->file('reference_2_letter')->getClientOriginalName()){
                        $reference_2_letter = $application->ppmv->reference_2_letter;
                    }else{
                        $reference_2_letter = FileUpload::upload($request->file('reference_2_letter'), $private = false, 'ppmv', 'reference_2_letter');
        
                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'ppmv'. DIRECTORY_SEPARATOR . $application->ppmv->reference_2_letter);
                        File::Delete($path);
                    }
                }else{
                    $reference_2_letter = $application->ppmv->reference_2_letter;
                }


                Registration::where(['user_id' => Auth::user()->id, 'id' => $id, 'type' => 'ppmv'])->update([
                    'status' => 'send_to_state_office',
                ]);

                PpmvLocationApplication::where(['user_id' => Auth::user()->id, 'registration_id' => $id])->update([
                    'user_id' => Auth::user()->id,
                    'registration_id' => $application->id,
    
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

            }

            DB::commit();

            return redirect()->route('ppmv-application-status')
            ->with('success', 'Application successfully updated.');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }
}
