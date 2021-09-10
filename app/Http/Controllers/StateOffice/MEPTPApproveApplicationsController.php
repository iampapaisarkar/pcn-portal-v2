<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MEPTPApplication;
use App\Models\Batch;
use App\Models\School;

class MEPTPApproveApplicationsController extends Controller
{
    public function batches(){

        $batches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'send_to_pharmacy_practice');
            $q->where('payment', true);
            $q->where('state', Auth::user()->state);
        })
        ->get();

        return view('stateoffice.meptp.approve.meptp-approve-batches', compact('batches'));
    }

    public function centre($batchID){

        $schools = School::where('state', Auth::user()->state)
        ->where('status', true)
        ->get();

        foreach($schools as $key => $school){
            $totalApplication = MEPTPApplication::where('status', 'send_to_pharmacy_practice')
            ->where('payment', true)
            ->where('batch_id', $batchID)
            ->where('traing_centre', $school->id)
            ->count();

            $schools[$key]['total_application'] =  $totalApplication;
            $schools[$key]['batch_id'] =  $batchID;
        }

        return view('stateoffice.meptp.approve.meptp-approve-centre', compact('schools'));
    }

    public function lists(Request $request){

        if(School::where('state', Auth::user()->state)->where('id', $request->school_id)->exists()){

            $applications = MEPTPApplication::where(['traing_centre' => $request->school_id, 'batch_id' => $request->batch_id])
            ->with('user_state', 'user_lga', 'school', 'batch', 'user')
            ->where('status', 'send_to_pharmacy_practice');
            
            if($request->per_page){
                $perPage = (integer) $request->per_page;
            }else{
                $perPage = 10;
            }
    
            if(!empty($request->search)){
                $search = $request->search;
                $applications = $applications->where(function($q) use ($search){
                    $q->where('m_e_p_t_p_applications.shop_name', 'like', '%' .$search. '%');
                    $q->orWhere('m_e_p_t_p_applications.shop_address', 'like', '%' .$search. '%');
                });
            }
    
            $applications = $applications->latest()->paginate($perPage);

            return view('stateoffice.meptp.approve.meptp-approve-lists', compact('applications'));
        }else{
            return abort(404);
        }
    }

    public function show(Request $request){

        if(MEPTPApplication::where('id', $request->application_id)
        ->where('batch_id', $request->batch_id)
        ->where('traing_centre', $request->school_id)
        ->where('vendor_id', $request->vendor_id)
        ->where('status', 'send_to_pharmacy_practice')
        ->where('payment', true)
        ->exists()){

            $application = MEPTPApplication::where('id', $request->application_id)
            ->where('batch_id', $request->batch_id)
            ->where('traing_centre', $request->school_id)
            ->where('vendor_id', $request->vendor_id)
            ->where('status', 'send_to_pharmacy_practice')
            ->where('payment', true)
            ->first();

            return view('stateoffice.meptp.approve.meptp-approve-show', compact('application'));
        }else{
            return abort(404);
        }
    }
}
