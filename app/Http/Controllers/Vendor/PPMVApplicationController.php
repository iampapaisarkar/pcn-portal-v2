<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PPMV\PPMVApplicationStoreRequest;
use App\Http\Requests\PPMV\PPMVApplicationUpdateRequest;
use App\Http\Services\FileUpload;
use App\Http\Services\Checkout;
use App\Models\PPMVApplication;
use App\Models\PPMVRenewal;
use DB;
use PDF;
use File;
use Storage;

class PPMVApplicationController extends Controller
{
    public function applicationForm(){

        $shop = Auth::user()->passed_meptp_application()->first();

        return view('vendor-user.ppmv.ppmv-application', compact('shop'));
    }

    public function applicationSubmit(PPMVApplicationStoreRequest $request){
        try {
            DB::beginTransaction();

            if(PPMVApplication::where('vendor_id', Auth::user()->id)->exists()){
                PPMVApplication::where('vendor_id', Auth::user()->id)->delete();
                PPMVRenewal::where('vendor_id', Auth::user()->id)->delete();
            }

            $meptp = Auth::user()->passed_meptp_application()->first();

            $reference_1_letter = FileUpload::upload($request->file('reference_1_letter'), $private = true, 'ppmv', 'reference_1_letter');
            $reference_2_letter = FileUpload::upload($request->file('reference_2_letter'), $private = true, 'ppmv', 'reference_2_letter');

            // Store MEPTP application 
            $application = PPMVApplication::create([
                'vendor_id' => Auth::user()->id,
                'meptp_application_id' => $meptp->id,
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

            $renewal = PPMVRenewal::create([
                'vendor_id' => Auth::user()->id,
                'meptp_application_id' => $meptp->id,
                'ppmv_application_id' => $application->id,
                'renewal_year' => date('Y'),
                'expires_at' => \Carbon\Carbon::now()->format('Y') .'-12-31', //\Carbon\Carbon::now()->addYear()->subDays(1),
                'status' => 'pending',
                'renewal' => false,
                'inspection' => true,
                // 'payment' => true, // should remove this field
            ]);


            $response = Checkout::checkoutMEPTP($application = ['id' => $renewal->id], 'ppmv_registration');

            DB::commit();

                return redirect()->route('invoices.show', ['id' => $response['id']])
                ->with('success', 'Application successfully submitted. Please pay amount for further action');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }

    public function applicationFormEdit($id){

        $application = PPMVApplication::select('p_p_m_v_applications.*', 'p_p_m_v_renewals.id as renewal_id')
        ->join('p_p_m_v_renewals', 'p_p_m_v_renewals.ppmv_application_id', 'p_p_m_v_applications.id')
        ->where('p_p_m_v_applications.id', $id)
        ->where('p_p_m_v_applications.vendor_id', Auth::user()->id)
        ->where(function($q){
            $q->where('p_p_m_v_renewals.status', 'rejected');
            $q->orWhere('p_p_m_v_renewals.status', 'unrecommended');
        })
        ->latest()
        ->with('user', 'meptp')
        ->first();

        if($application){
            return view('vendor-user.ppmv.ppmv-application-edit', compact('application'));
        }else{
            return abort(404);
        }
    }

    public function applicationFormUpdate(PPMVApplicationUpdateRequest $request, $id){

        try {
            DB::beginTransaction();

            $renewal = PPMVRenewal::where(['vendor_id' => Auth::user()->id, 'id' => $id])
            ->with('ppmv_application', 'meptp_application')
            ->first();

            if(PPMVApplication::where(['vendor_id' => Auth::user()->id, 'id' => $renewal->ppmv_application->id])->exists()){

                $application = PPMVApplication::where(['vendor_id' => Auth::user()->id, 'id' => $renewal->ppmv_application->id])->first();

                if($request->file('reference_1_letter') != null){
                    if($application->reference_1_letter == $request->file('reference_1_letter')->getClientOriginalName()){
                        $reference_1_letter = $application->reference_1_letter;
                    }else{
                        $reference_1_letter = FileUpload::upload($request->file('reference_1_letter'), $private = true, 'ppmv', 'reference_1_letter');
        
                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'PPMV'. DIRECTORY_SEPARATOR . $application->reference_1_letter);
                        File::Delete($path);
                    }
                }else{
                    $reference_1_letter = $application->reference_1_letter;
                }

                if($request->file('reference_2_letter') != null){
                    if($application->reference_2_letter == $request->file('reference_2_letter')->getClientOriginalName()){
                        $reference_2_letter = $application->reference_2_letter;
                    }else{
                        $reference_2_letter = FileUpload::upload($request->file('reference_2_letter'), $private = true, 'ppmv', 'reference_2_letter');
        
                        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
                        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'PPMV'. DIRECTORY_SEPARATOR . $application->reference_2_letter);
                        File::Delete($path);
                    }
                }else{
                    $reference_2_letter = $application->reference_2_letter;
                }
                

                PPMVApplication::where(['vendor_id' => Auth::user()->id, 'id' => $renewal->ppmv_application->id])
                ->update([
                    'vendor_id' => Auth::user()->id,
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
                    'created_at' => now(),
                ]);

                PPMVRenewal::where(['vendor_id' => Auth::user()->id, 'id' => $id])
                ->update([
                    'status' => 'pending',
                ]);

                $response = true;
               
            }else{
                $response = false;
            }

            DB::commit();

                if($response == true){
                    return redirect()->route('ppmv-application')
                    ->with('success', 'Application successfully updated');
                }else{
                    return back()->with('error','There is something error, please try after some time');
                }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }
    }

    public function downloadReport($id){
        $application = PPMVRenewal::where('id', $id)->first();
        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
        DIRECTORY_SEPARATOR . $application->vendor_id . DIRECTORY_SEPARATOR . 'PPMV' . DIRECTORY_SEPARATOR . $application->inspection_report);
        return response()->download($path);
        
    }

    public function renewal(){

        $renewals = PPMVRenewal::where('vendor_id', Auth::user()->id)
        ->where('renewal', true)
        ->with('user', 'ppmv_application', 'meptp_application')
        ->latest()
        ->get();

        // dd($renewals);

        return view('vendor-user.ppmv.ppmv-renewal', compact('renewals'));
    }


    public function downloadLicence($id){

        if(PPMVRenewal::where('vendor_id',  Auth::user()->id)
        ->where('id',  $id)
        ->where('status', 'licence_issued')->exists()){

            $data = PPMVRenewal::where('vendor_id',  Auth::user()->id)
            ->where('id',  $id)
            ->where('status', 'licence_issued')
            ->with('meptp_application', 'ppmv_application', 'user')
            ->first();

            // $backgroundURL = public_path('admin/dist-assets/images/licence-bg.jpg');
            // $profilePhoto = Auth::user()->photo ? public_path('images/'. Auth::user()->photo) : public_path('admin/dist-assets/images/avatar.jpg');

            $backgroundURL = env('APP_URL') . '/admin/dist-assets/images/licence-bg.jpg';
            $profilePhoto = Auth::user()->photo ? env('APP_URL') . '/images/'. Auth::user()->photo : env('APP_URL') . '/admin/dist-assets/images/avatar.jpg';

            $pdf = PDF::loadView('pdf.licence', ['data' => $data, 'background' => $backgroundURL, 'photo' => $profilePhoto]);
            return $pdf->stream();
        }else{
            return abort(404);
        }
    }


    public function renewLicence(){

        $application = PPMVApplication::where('vendor_id', Auth::user()->id)
        ->with('meptp')
        ->first();

        return view('vendor-user.ppmv.ppmv-renew-lincence', compact('application'));
    }

    public function submitRenewLicence(Request $request){

        $application = PPMVApplication::where('vendor_id', Auth::user()->id)
        ->with('meptp')
        ->first();

        $PPMVRenwal = PPMVRenewal::where('vendor_id', Auth::user()->id)->orderBy('renewal_year', 'desc')->first();

        try {
            DB::beginTransaction();

            $renewal = PPMVRenewal::create([
                'vendor_id' => Auth::user()->id,
                'meptp_application_id' => $application->meptp->id,
                'ppmv_application_id' => $application->id,
                'renewal_year' => date('Y'),
                'expires_at' => \Carbon\Carbon::now()->format('Y') .'-12-31', //\Carbon\Carbon::now()->addYear()->subDays(1),
                'status' => 'pending',
                'inspection' => $PPMVRenwal->inspection == true ? false : true,
                // 'payment' => true, // should remove this field
            ]);

            $response = Checkout::checkoutMEPTP($application = ['id' => $renewal->id], 'ppmv_renewal');

            DB::commit();

                return redirect()->route('invoices.show', ['id' => $response['id']])
                ->with('success', 'Renewal Application successfully submitted. Please pay amount for further action');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        } 
    }
}
