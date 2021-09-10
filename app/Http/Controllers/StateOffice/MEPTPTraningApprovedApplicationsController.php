<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MEPTPApplication;
use App\Models\MEPTPResult;
use App\Models\MEPTPIndexNumber;
use App\Models\Batch;
use App\Models\State;
use App\Models\School;
use DB;

class MEPTPTraningApprovedApplicationsController extends Controller
{
    public function batches(){

        // Wihtout Index and Result  
        $withoutIndexBatches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'approved_tier_selected');
            $q->where('index_number_id', null);
            $q->where('payment', true);
            $q->where('state', Auth::user()->state);
        })
        ->with('meptpApplication.result')
        ->latest()
        ->get();

        foreach($withoutIndexBatches as $key => $batch){
            foreach($batch->meptpApplication as $application){
                if($application->index_number_id == null){
                    $withoutIndexBatches[$key]['index_status'] = 'false';
                }
            }
            $withoutIndexBatches[$key]['result_status'] = 'false';
        }

        // With Index but Without Result 
        $withIndexNDWithoutResultBatches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'index_generated');
            $q->where('payment', true);
            $q->where('state', Auth::user()->state);
            $q->whereHas('result', function($q){
                $q->where('status', 'pending');
                $q->where('score', null);
                $q->where('percentage', null);
            });
        })
        ->with('meptpApplication.result')
        ->latest()
        ->get();

        foreach($withIndexNDWithoutResultBatches as $key => $batch){
            foreach($batch->meptpApplication as $application){
                if($application->index_number_id != null){
                    $withIndexNDWithoutResultBatches[$key]['index_status'] = 'true';
                }
            }
            $withIndexNDWithoutResultBatches[$key]['result_status'] = 'false';
        }

        // With Index and With Result 
        $withIndexNDWithResultBatches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'pass');
            $q->orWhere('status', 'fail');
            $q->where('payment', true);
            $q->where('state', Auth::user()->state);
            $q->whereHas('result', function($q){
                $q->where('status', '!=', 'pending');
                $q->where('score', '!=', null);
                $q->where('percentage', '!=', null);
            });
        })
        ->with('meptpApplication.result')
        ->latest()
        ->get();

        foreach($withIndexNDWithResultBatches as $key => $batch){
            foreach($batch->meptpApplication as $application){
                if($application->index_number_id != null){
                    $withIndexNDWithResultBatches[$key]['index_status'] = 'true';
                }
            }
            $withIndexNDWithResultBatches[$key]['result_status'] = 'true';
        }

        

        $batches = (object) array_merge(
            (array) $withoutIndexBatches->toArray(), (array) $withIndexNDWithoutResultBatches->toArray(),
            (array) $withIndexNDWithResultBatches->toArray());

        return view('stateoffice.meptp.trainingapproved.meptp-training-approved-batches', compact('batches'));
    }

    public function centre(Request $request){

        if(($request->index == 'true' || $request->index == 'false') &&
        ($request->result == 'true' || $request->result == 'false') &&
        isset($request->batch_id)){

            $schools = School::where('state', Auth::user()->state)
            ->where('status', true)
            ->get();

            foreach($schools as $key => $school){
                if($request->index == 'false' && $request->result == 'false'){
                    $totalApplication = MEPTPApplication::where('status', 'approved_tier_selected')
                    ->where('payment', true)
                    ->where('batch_id', $request->batch_id)
                    ->where('traing_centre', $school->id)
                    ->count();
    
                    $schools[$key]['total_application'] =  $totalApplication;
                    $schools[$key]['batch_id'] =  $request->batch_id;
                }
                if($request->index == 'true' && $request->result == 'false'){
                    $totalApplication = MEPTPApplication::where('index_number_id', '!=', null)
                    ->where(function($q){
                        $q->where('status', '!=', 'pass');
                        $q->orWhere('status', '!=', 'fail');
                    })
                    ->where('payment', true)
                    ->where('batch_id', $request->batch_id)
                    ->where('traing_centre', $school->id)
                    ->count();
    
                    $schools[$key]['total_application'] =  $totalApplication;
                    $schools[$key]['batch_id'] =  $request->batch_id;
                }
                if($request->index == 'true' && $request->result == 'true'){
                    $totalApplication = MEPTPApplication::where('index_number_id', '!=', null)
                    ->where(function($q){
                        $q->where('status', 'pass');
                        $q->orWhere('status', 'fail');
                    })
                    ->where('payment', true)
                    ->where('batch_id', $request->batch_id)
                    ->where('traing_centre', $school->id)
                    ->count();
    
                    $schools[$key]['total_application'] =  $totalApplication;
                    $schools[$key]['batch_id'] =  $request->batch_id;
                }
                
            }

            return view('stateoffice.meptp.trainingapproved.meptp-training-approved-centre', compact('schools'));
        }else{
            return abort(404);
        }
    }

    public function lists(Request $request){

        if(($request->index == 'true' || $request->index == 'false') &&
        ($request->result == 'true' || $request->result == 'false') &&
        isset($request->batch_id)){

            if(School::where('state', Auth::user()->state)->where('id', $request->school_id)->exists()){

                if($request->index == 'false' && $request->result == 'false'){
                    $applications = MEPTPApplication::where(['traing_centre' => $request->school_id, 'batch_id' => $request->batch_id])
                    ->with('user_state', 'user_lga', 'school', 'batch', 'user', 'indexNumber', 'result')
                    ->where('payment', true)
                    ->where('status', 'approved_tier_selected');
                }
                if($request->index == 'true' && $request->result == 'false'){
                    $applications = MEPTPApplication::where(['traing_centre' => $request->school_id, 'batch_id' => $request->batch_id])
                    ->with('user_state', 'user_lga', 'school', 'batch', 'user', 'indexNumber', 'result')
                    ->where('payment', true)
                    ->where('status', 'index_generated')
                    ->where('index_number_id', '!=', null);
                }
                if($request->index == 'true' && $request->result == 'true'){
                    $applications = MEPTPApplication::where(['traing_centre' => $request->school_id, 'batch_id' => $request->batch_id])
                    ->with('user_state', 'user_lga', 'school', 'batch', 'user', 'indexNumber', 'result')
                    ->where('payment', true)
                    ->where(function($q){
                        $q->where('status', 'pass');
                        $q->orWhere('status', 'fail');
                    })
                    ->where('index_number_id', '!=', null);
                }
                
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

                return view('stateoffice.meptp.trainingapproved.meptp-training-approved-lists', compact('applications'));
            }else{
                return abort(404);
            }
        }else{
            return abort(404);
        }
    }

    public function show($applicationID){

        if(MEPTPApplication::where('id', $applicationID)
        ->where(function($q){
            $q->where('status', 'approved_tier_selected');
            $q->orWhere('status', 'index_generated');
            $q->orWhere('status', 'pass');
            $q->orWhere('status', 'fail');
        })
        ->exists()){

            $application = MEPTPApplication::where('id', $applicationID)
            ->where(function($q){
                $q->where('status', 'approved_tier_selected');
                $q->orWhere('status', 'index_generated');
                $q->orWhere('status', 'pass');
                $q->orWhere('status', 'fail');
            })
            ->first();

            return view('stateoffice.meptp.trainingapproved.meptp-training-approved-show', compact('application'));
        }else{
            return abort(404);
        }
    }
}
