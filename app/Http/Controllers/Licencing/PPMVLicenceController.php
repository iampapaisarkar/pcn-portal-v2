<?php

namespace App\Http\Controllers\Licencing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PPMVApplication;
use App\Models\PPMVRenewal;
use App\Http\Services\AllActivity;
use App\Http\Services\FileUpload;
use DB;
use PDF;
use App\Jobs\GenerateLicenceEmailJOB;

class PPMVLicenceController extends Controller
{
    public function pendingLists(Request $request){
        
        $licences = PPMVRenewal::where('payment', true)
        ->where('status', 'recommended')
        ->with('user', 'ppmv_application', 'meptp_application');

        if($request->per_page){
            $perPage = (integer) $request->per_page;
        }else{
            $perPage = 10;
        }

        if(!empty($request->search)){
            $search = $request->search;
            $licences = $licences->whereHas('user', function($q) use ($search){
                $q->where('firstname', 'like', '%' .$search. '%');
                $q->orWhere('lastname', 'like', '%' .$search. '%');
            })
            ->orWhereHas('meptp_application', function($q) use ($search){
                $q->where('shop_name', 'like', '%' .$search. '%');
            });
        }

        $licences = $licences->latest()->paginate($perPage);

        return view('licencing.ppmv-licence-pending-lists', compact('licences'));
    }

    public function pendingShow($id){
        
        $licence = PPMVRenewal::where('payment', true)
        ->where('status', 'recommended')
        ->where('id', $id)
        ->with('user', 'ppmv_application', 'meptp_application')
        ->first();

        if($licence){
            return view('licencing.ppmv-licence-pending-show', compact('licence'));
        }else{
            return abort(404);
        }

    }

    public function issueSingleLicence($id){

        $app = PPMVRenewal::where('payment', true)
        ->where('status', 'recommended')
        ->where('id', $id)
        ->with('meptp_application')
        ->first();

        $licencecount = PPMVRenewal::where('payment', true)->count();

        $licenceNO = strtoupper($app->meptp_application->user_state->name) . 
        substr($app->renewal_year, -2) . 
        strtoupper($app->meptp_application->tier->name[0]) . $app->meptp_application->tier->name[5] .
        000 .
        $licencecount++;
        
        PPMVRenewal::where('payment', true)
        ->where('status', 'recommended')
        ->where('id', $id)
        ->update([
            'status' => 'licence_issued',
            'renewal' => true,
            'licence' => $licenceNO
        ]);

        // Send Licence Email 
        $licence = PPMVRenewal::where('id',  $id)
        ->where('status', 'licence_issued')
        ->with('meptp_application', 'ppmv_application', 'user')
        ->first();

        $data = [
            'licence' => $licence,
            'vendor' => $licence->user
        ];
        GenerateLicenceEmailJOB::dispatch($data);

        $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
        $activity = 'Registration and Licencing Issue The Licence';
        AllActivity::storeActivity($id, $adminName, $activity, 'ppmv');

        return redirect()->route('ppmv-licence-pending-lists')->with('success', 'Licence successfully issued');
    }

    public function issueLicences(Request $request){
        
        try {
            DB::beginTransaction();

            $checkboxes = isset($request->check_box_bulk_action) ? true : false;
            if($checkboxes == true){
                foreach($request->check_box_bulk_action as $renewal_id => $application){

                    $app = PPMVRenewal::where('payment', true)
                    ->where('status', 'recommended')
                    ->where('id', $renewal_id)
                    ->with('meptp_application')
                    ->first();

                    $licencecount = PPMVRenewal::where('payment', true)->count();

                    $licenceNO = strtoupper($app->meptp_application->user_state->name) . 
                    substr($app->renewal_year, -2) . 
                    strtoupper($app->meptp_application->tier->name[0]) . $app->meptp_application->tier->name[5] .
                    000 .
                    $licencecount++;

                    PPMVRenewal::where('payment', true)
                    ->where('status', 'recommended')
                    ->where('id', $renewal_id)
                    ->update([
                        'status' => 'licence_issued',
                        'renewal' => true,
                        'licence' => $licenceNO
                    ]);

                    // Send Licence Email 
                    $licence = PPMVRenewal::where('id',  $renewal_id)
                    ->where('status', 'licence_issued')
                    ->with('meptp_application', 'ppmv_application', 'user')
                    ->first();

                    $data = [
                        'licence' => $licence,
                        'vendor' => $licence->user,
                    ];
                    GenerateLicenceEmailJOB::dispatch($data);

                    $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                    $activity = 'Registration and Licencing Issue The Licence';
                    AllActivity::storeActivity($renewal_id, $adminName, $activity, 'ppmv');
                  
                }

                $response = true;
            }else{
                $response = false;
            }

        DB::commit();

            if($response == true){
                return back()->with('success', 'Licence successfully issued for selected applications.');
            }else{
                return back()->with('error', 'Please select atleast one apllication.');
            }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }

    }


    public function issuedLists(Request $request){
        
        $licences = PPMVRenewal::where('payment', true)
        ->where('status', 'licence_issued')
        ->with('user', 'ppmv_application', 'meptp_application');

        if($request->per_page){
            $perPage = (integer) $request->per_page;
        }else{
            $perPage = 10;
        }

        if(!empty($request->search)){
            $search = $request->search;
            $licences = $licences->whereHas('user', function($q) use ($search){
                $q->where('firstname', 'like', '%' .$search. '%');
                $q->orWhere('lastname', 'like', '%' .$search. '%');
            })
            ->orWhereHas('meptp_application', function($q) use ($search){
                $q->where('shop_name', 'like', '%' .$search. '%');
            });
        }

        $licences = $licences->latest()->paginate($perPage);

        return view('licencing.ppmv-licence-issued-lists', compact('licences'));
    }

    public function issuedShow($id){
        
        $licence = PPMVRenewal::where('payment', true)
        ->where('status', 'licence_issued')
        ->where('id', $id)
        ->with('user', 'ppmv_application', 'meptp_application')
        ->first();

        if($licence){
            return view('licencing.ppmv-licence-issued-show', compact('licence'));
        }else{
            return abort(404);
        }

    }
}
