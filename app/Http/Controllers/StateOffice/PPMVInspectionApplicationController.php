<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PPMVApplication;
use App\Models\PPMVRenewal;
use App\Http\Services\AllActivity;
use App\Http\Services\FileUpload;
use DB;
use App\Jobs\PPMVLicenceQueryEmailJOB;

class PPMVInspectionApplicationController extends Controller
{
    public function applications(Request $request){
        
        $applications = PPMVRenewal::where('payment', true)
        ->where('status', 'approved')
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

        return view('stateoffice.ppmv.inspection.ppmv-inspection-lists', compact('applications'));
    }

    public function show($id){

        $application = PPMVRenewal::where('id', $id)
        ->where('payment', true)
        ->where('status', 'approved')
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->with('user', 'ppmv_application', 'meptp_application')
        ->first();

        if($application){
            return view('stateoffice.ppmv.inspection.ppmv-inspection-show', compact('application'));
        }else{
            return abort(404);
        }
    }

    public function submitInspectionReport(Request $request, $id){
        $this->validate($request, [
            'recommendation' => ['required'],
            'inspection_report' => ['required']
        ]);

        try {
            DB::beginTransaction();

            $application = PPMVRenewal::where('id', $id)->with('ppmv_application', 'meptp_application', 'user')->first();

            if($application){

                $file = $request->file('inspection_report');

                $private_storage_path = storage_path(
                    'app'. DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . $application->vendor_id . DIRECTORY_SEPARATOR . 'PPMV'
                );

                if(!file_exists($private_storage_path)){
                    \mkdir($private_storage_path, intval('755',8), true);
                }
                $file_name = 'vendor'.$application->vendor_id.'-inspection_report.'.$file->getClientOriginalExtension();
                $file->move($private_storage_path, $file_name);

                PPMVRenewal::where('id', $id)
                ->where('status', 'approved')
                ->where('payment', true)
                ->update([
                    'status' => $request->recommendation,
                    'inspection_report' => $file_name,
                ]);

                if($request->recommendation == 'unrecommended'){
                    $application = PPMVRenewal::where('id', $id)
                    ->where('payment', true)
                    ->with('user')
                    ->first();
                    
                    $data = [
                        'application' => $application,
                        'vendor' => $application->user,
                    ];
                    PPMVLicenceQueryEmailJOB::dispatch($data);
                }

                $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                $activity = 'State Officer Upload Inspection Report';
                AllActivity::storeActivity($application->id, $adminName, $activity, 'ppmv');
            }
            
            DB::commit();

            return redirect()->route('ppmv-inspection-applications')
            ->with('success', 'Inspection Report updated successfully');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }
}
