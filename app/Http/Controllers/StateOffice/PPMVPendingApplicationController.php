<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PPMVApplication;
use App\Models\PPMVRenewal;
use App\Http\Services\AllActivity;
use App\Http\Services\BasicInformation;
use App\Jobs\PPMVDocQueryEmailJOB;

class PPMVPendingApplicationController extends Controller
{
    public function applications(Request $request){
        
        $applications = PPMVRenewal::where('payment', true)
        ->where('status', 'pending')
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->with('user', 'ppmv_application', 'meptp_application');

        if($request->per_page){
            $perPage = (integer) $request->per_page;
        }else{
            $perPage = 10;
        }

        if(!empty($request->search)){
            $search = $request->search;
            $applications = $applications->whereHas('user', function($q) use ($search){
                $q->where('firstname', 'like', '%' .$search. '%');
                $q->orWhere('lastname', 'like', '%' .$search. '%');
            })
            ->orWhereHas('meptp_application', function($q) use ($search){
                $q->where('shop_name', 'like', '%' .$search. '%');
            });
        }

        $applications = $applications->latest()->paginate($perPage);

        return view('stateoffice.ppmv.pending.ppmv-pending-lists', compact('applications'));
    }

    public function show($id){

        $application = PPMVRenewal::where('id', $id)
        ->where('payment', true)
        ->where('status', 'pending')
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->with('user', 'ppmv_application', 'meptp_application')
        ->first();

        if($application){
            return view('stateoffice.ppmv.pending.ppmv-pending-show', compact('application'));
        }else{
            return abort(404);
        }
    }


    public function downloadDocument(Request $request){
        if($request->type == 'reference_1_letter'){
            $filename = PPMVApplication::where(['vendor_id' => $request->user_id, 'id' => $request->id])->first()->reference_1_letter;
        }
        if($request->type == 'reference_2_letter'){
            $filename = PPMVApplication::where(['vendor_id' => $request->user_id, 'id' => $request->id])->first()->reference_2_letter;
        }

        $path = storage_path('app'. DIRECTORY_SEPARATOR . 'private' . 
        DIRECTORY_SEPARATOR . $request->user_id . DIRECTORY_SEPARATOR . 'PPMV' . DIRECTORY_SEPARATOR . $filename);
        return response()->download($path);
    }

    public function approve(Request $request){

        if(PPMVRenewal::where('id', $request->application_id)
        ->where('vendor_id', $request->vendor_id)
        ->where('payment', true)
        ->where('status', 'pending')
        ->exists()){

            $ppmv_application = PPMVRenewal::where('id', $request->application_id)
            ->where('vendor_id', $request->vendor_id)
            ->where('payment', true)
            ->where('status', 'pending')
            ->with('ppmv_application')
            ->first();

            if($ppmv_application->inspection == true){
                $status = 'approved';
            }else{
                $status = 'recommended';
            }

            $application = PPMVRenewal::where('id', $request->application_id)
            ->where('vendor_id', $request->vendor_id)
            ->where('payment', true)
            ->where('status', 'pending')
            ->update([
                'status' => $status,
                'query' => null,
                'token' => md5(uniqid(rand(), true)),
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'State Officer Document Verification Approved';
            AllActivity::storeActivity($request->application_id, $adminName, $activity, 'ppmv');

            return redirect()->route('meptp-pending-batches')->with('success', 'Application Approved successfully done');
        }else{
            return abort(404);
        }
    }

    public function query(Request $request){
       
        $this->validate($request, [
            'query' => ['required'],
        ]);

        if(PPMVRenewal::where('id', $request->application_id)
        ->where('vendor_id', $request->vendor_id)
        ->where('payment', true)
        ->where('status', 'pending')
        ->exists()){

            PPMVRenewal::where('id', $request->application_id)
            ->where('vendor_id', $request->vendor_id)
            ->where('payment', true)
            ->where('status', 'pending')
            ->update([
                'status' => 'rejected',
                'query' => $request['query'],
            ]);

            $application = PPMVRenewal::where('id', $request->application_id)
            ->where('vendor_id', $request->vendor_id)
            ->where('payment', true)
            ->with('user')
            ->first();

            $data = [
                'application' => $application,
                'vendor' => $application->user,
            ];
            PPMVDocQueryEmailJOB::dispatch($data);


            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'State Officer Document Verification Query';
            AllActivity::storeActivity($request->application_id, $adminName, $activity, 'ppmv');

            return redirect()->route('meptp-pending-batches')->with('success', 'Application Queried successfully');
        }else{
            return abort(404);
        }

        // if(PPMVApplication::where('id', $request->application_id)
        // ->where('vendor_id', $request->vendor_id)
        // ->where('status', 'send_to_state_office')
        // ->where('payment', true)
        // ->exists()){
        //     $application = PPMVApplication::where('id', $request->application_id)
        //     ->where('vendor_id', $request->vendor_id)
        //     ->where('status', 'send_to_state_office')
        //     ->where('payment', true)
        //     ->update([
        //         'status' => 'rejected',
        //         'query' => $request['query'],
        //     ]);

        //     $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
        //     $activity = 'State Officer Document Verification Query';
        //     AllActivity::storeActivity($request->application_id, $adminName, $activity, 'ppmv');

        //     return redirect()->route('meptp-pending-batches')->with('success', 'Application Queried successfully');
        // }else{
        //     return back()->with('error', 'There is something error, please try after some time');
        // }
    }
}
