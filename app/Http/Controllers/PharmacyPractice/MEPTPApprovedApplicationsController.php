<?php

namespace App\Http\Controllers\PharmacyPractice;

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
use PDF;
use App\Http\Services\AllActivity;
use App\Jobs\MEPTPExamInfoEmailJOB;

class MEPTPApprovedApplicationsController extends Controller
{
    public function batches(){

        $withoutIndexBatches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'approved_tier_selected');
            $q->where('index_number_id', null);
            $q->where('payment', true);
        })
        ->with('meptpApplication')
        ->get();

        foreach($withoutIndexBatches as $key => $batch){
            foreach($batch->meptpApplication as $application){
                if($application->index_number_id == null){
                    $withoutIndexBatches[$key]['index_number_generated'] = false;
                    $withoutIndexBatches[$key]['status'] = 'false';
                }
            }
        }

        $withIndexBatches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'index_generated');
            $q->where('index_number_id', '!=', null);
            $q->where('payment', true);
        })
        ->with('meptpApplication')
        ->get();

        foreach($withIndexBatches as $key => $batch){
            foreach($batch->meptpApplication as $application){
                if($application->index_number_id != null){
                    $withIndexBatches[$key]['index_number_generated'] = true;
                    $withIndexBatches[$key]['status'] = 'true';
                }
            }
        }

        $batches = (object) array_merge(
            (array) $withoutIndexBatches->toArray(), (array) $withIndexBatches->toArray());

        // dd($batches);

        return view('pharmacypractice.meptp.approved.meptp-approved-batches', compact('batches'));
    }

    public function states($batchID, Request $request){

        if($request->status == 'false' || $request->status == 'true'){

            $states = State::get();

            foreach($states as $key => $state){
                $totalApplication = MEPTPApplication::where('payment', true);

                if($request->status == 'true'){
                    $totalApplication = $totalApplication->where('status', 'index_generated')
                    ->where('index_number_id', '!=', null);
                }else{
                    $totalApplication = $totalApplication->where('status', 'approved_tier_selected')
                    ->where('index_number_id', null);
                }
                $totalApplication = $totalApplication->whereHas('user.user_state', function($q) use($state){
                    $q->where('states.id', $state->id);
                })
                ->count();

                $states[$key]['total_application'] =  $totalApplication;
            }
            return view('pharmacypractice.meptp.approved.meptp-approved-states', compact('states', 'batchID'));
        }else{
            return abort(404);
        }

    }

    public function centre($stateID, Request $request){
        if($request->status == 'false' || $request->status == 'true'){

            $schools = School::where('state', $stateID)
            ->where('status', true)
            ->get();

            foreach($schools as $key => $school){
                $totalApplication = MEPTPApplication::where('payment', true)
                ->where('batch_id', $request->batch_id);

                if($request->status == 'true'){
                    $totalApplication = $totalApplication->where('status', 'index_generated')
                    ->where('index_number_id', '!=', null);
                }else{
                    $totalApplication = $totalApplication->where('status', 'approved_tier_selected')
                    ->where('index_number_id', null);
                }

                $totalApplication = $totalApplication->where('traing_centre', $school->id)
                ->count();

                $schools[$key]['total_application'] =  $totalApplication;
            }
            $batchID = $request->batch_id;
            return view('pharmacypractice.meptp.approved.meptp-approved-centre', compact('schools', 'batchID'));
        }else{
            return abort(404);
        }
    }

    public function lists(Request $request){

        if($request->status == 'false' || $request->status == 'true'){

            if(School::where('id', $request->school_id)->exists()){

                $applications = MEPTPApplication::where(['traing_centre' => $request->school_id])
                ->where('batch_id', $request->batch_id)
                ->with('user_state', 'user_lga', 'school', 'batch', 'user', 'tier');

                if($request->status == 'true'){
                    $applications = $applications->where('status', 'index_generated')
                    ->where('index_number_id', '!=', null);
                }else{
                    $applications = $applications->where('status', 'approved_tier_selected')
                    ->where('index_number_id', null);
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

                return view('pharmacypractice.meptp.approved.meptp-approved-lists', compact('applications'));
            }else{
                return abort(404);
            }
        }else{
            return abort(404);
        }

    }

    public function generateIndexNumber(Request $request){
        try {
            DB::beginTransaction();

            $checkboxes = isset($request->check_box_bulk_action) ? true : false;
            if($checkboxes == true){
                foreach($request->check_box_bulk_action as $application_id => $application){

                    $app = MEPTPApplication::where('id', $application_id)
                    ->where('index_number_id', null)
                    ->with('user_state', 'user_lga', 'school', 'batch', 'user', 'tier')
                    ->where('status', 'approved_tier_selected')
                    ->first();     
                    
                    if(Batch::where(['status' => true, 'id' => $app->batch_id])->exists()){
                        return back()->with('error', 'You can\'t generate index number & examination card during batch is active');
                    }
                    
                    $indexNumber = MEPTPIndexNumber::create([
                        'batch_year' => $app->batch->batch_no . '-' . $app->batch->year, 
                        'state_code' => $app->user_state->state_code ? strtoupper($app->user_state->state_code) : 'STATE', 
                        'school_code' => $app->school->code ? strtoupper($app->school->code) : 'SCHOOL', 
                        'tier' => strtoupper($app->tier->name[0]) . $app->tier->name[5]
                    ]);

                    MEPTPApplication::where('id', $application_id)
                    ->where('index_number_id', null)
                    ->with('user_state', 'user_lga', 'school', 'batch', 'user', 'tier')
                    ->where('status', 'approved_tier_selected')
                    ->update([
                        'status' => 'index_generated',
                        'index_number_id' => $indexNumber->id
                    ]); 

                    $application = MEPTPApplication::where('id', $application_id)
                    ->with('user_state', 'user_lga', 'school', 'batch', 'user', 'tier')
                    ->where('status', 'index_generated')
                    ->first(); 


                    $data = [
                        'vendor' => $application->user
                    ];
                    MEPTPExamInfoEmailJOB::dispatch($data);


                    $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                    $activity = 'Index Number Generated';
                    AllActivity::storeActivity($app->id, $adminName, $activity, 'meptp');
                }

                $response = true;
            }else{
                $response = false;
            }

        DB::commit();

            if($response == true){
                return back()->with('success', 'Index number generated successfully.');
            }else{
                return back()->with('error', 'Please select atleast one application.');
            }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }
       
    }
}
