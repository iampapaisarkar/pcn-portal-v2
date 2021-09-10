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
use App\Http\Services\AllActivity;
use App\Exports\ResultTemplateExport;
use App\Imports\ResultImport;
use Excel;
use App\Jobs\MEPTPExamResultEmailJOB;

class MEPTPResultsApplicationsController extends Controller
{
    public function batches(){

        $withoutResultBatches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'index_generated');
            $q->where('payment', true);
            $q->whereHas('result', function($q){
                $q->where('status', 'pending');
                $q->where('score', null);
                $q->where('percentage', null);
            });
        })
        ->with('meptpApplication.result')
        ->latest()
        ->get();

        foreach($withoutResultBatches as $key => $batch){
            $withoutResultBatches[$key]['result_uploaded'] = false;
            $withoutResultBatches[$key]['status'] = 'false';
        }

        $withResultBatches = Batch::whereHas('meptpApplication', function($q){
            $q->where('status', 'fail');
            $q->orWhere('status', 'pass');
            $q->where('payment', true);
            $q->whereHas('result', function($q){
                $q->where('status', '!=', 'pending');
                $q->where('score', '!=', null);
                $q->where('percentage', '!=', null);
            });
        })
        ->with('meptpApplication.result')
        ->latest()
        ->get();

        foreach($withResultBatches as $key => $batch){
            $withResultBatches[$key]['result_uploaded'] = true;
            $withResultBatches[$key]['status'] = 'true';
        }

        $batches = (object) array_merge(
            (array) $withoutResultBatches->toArray(), (array) $withResultBatches->toArray());


        // $batches = Batch::whereHas('meptpApplication', function($q){
        //     $q->where('status', 'index_generated');
        //     $q->where('payment', true);
        // })
        // ->with('meptpApplication.result')
        // ->paginate(20);


        // dd($batches);

        return view('pharmacypractice.meptp.results.meptp-results-batches', compact('batches'));
    }

    public function states($batchID, Request $request){

        if($request->status == 'false' || $request->status == 'true'){

            $states = State::get();

            foreach($states as $key => $state){
                $totalApplication = MEPTPApplication::where('payment', true)
                ->where('batch_id', $batchID);

                if($request->status == 'true'){
                    $totalApplication = $totalApplication->where('status', '!=', 'index_generated')->whereHas('result', function($q){
                        $q->where('status', '!=', 'pending');
                        $q->where('score', '!=', null);
                        $q->where('percentage', '!=', null);
                    });
                }else{
                    $totalApplication = $totalApplication->where('status', 'index_generated')->whereHas('result', function($q){
                        $q->where('status', 'pending');
                        $q->where('score', null);
                        $q->where('percentage', null);
                    });
                }
                $totalApplication = $totalApplication->whereHas('user.user_state', function($q) use($state){
                    $q->where('states.id', $state->id);
                })
                ->count();

                $states[$key]['total_application'] =  $totalApplication;
            }
            return view('pharmacypractice.meptp.results.meptp-results-states', compact('states', 'batchID'));
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
                    $totalApplication = $totalApplication->where('status', '!=', 'index_generated')->whereHas('result', function($q){
                        $q->where('status', '!=', 'pending');
                        $q->where('score', '!=', null);
                        $q->where('percentage', '!=', null);
                    });
                }else{
                    $totalApplication = $totalApplication->where('status', 'index_generated')->whereHas('result', function($q){
                        $q->where('status', 'pending');
                        $q->where('score', null);
                        $q->where('percentage', null);
                    });
                }

                $totalApplication = $totalApplication->where('traing_centre', $school->id)
                ->count();

                $schools[$key]['total_application'] =  $totalApplication;
            }

            $batchID = $request->batch_id;

            return view('pharmacypractice.meptp.results.meptp-results-centre', compact('schools', 'batchID'));
        }else{
            return abort(404);
        }
    }

    public function lists(Request $request){

        if($request->status == 'false' || $request->status == 'true'){

            if(School::where('id', $request->school_id)->exists()){

                $applications = MEPTPApplication::where(['traing_centre' => $request->school_id])
                ->where('batch_id', $request->batch_id)
                ->with('user_state', 'user_lga', 'school', 'batch', 'user', 'tier', 'indexNumber');

                if($request->status == 'true'){
                    $applications = $applications
                    ->where('status', '!=', 'index_generated')->whereHas('result', function($q){
                        $q->where('status', '!=', 'pending');
                        $q->where('score', '!=', null);
                        $q->where('percentage', '!=', null);
                    });
                }else{
                    $applications = $applications
                    ->where('status', 'index_generated')->whereHas('result', function($q){
                        $q->where('status', 'pending');
                        $q->where('score', null);
                        $q->where('percentage', null);
                    });
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

                $schoolID = $request->school_id;
                $batchID = $request->batch_id;

                return view('pharmacypractice.meptp.results.meptp-results-lists', compact('applications', 'schoolID', 'batchID'));
            }else{
                return abort(404);
            }
        }else{
            return abort(404);
        }

    }

    public function downloadResultTemplate(Request $request){

        $data = MEPTPApplication::where(['batch_id'=>$request->batch_id, 'traing_centre'=>$request->school_id])
        ->where('status', 'index_generated')
        ->with('indexNumber', 'user', 'tier', 'batch', 'school')->get();
        // dd($data);
        $array = array();
        foreach ($data as $key => $value) {
            $fields = [
                'S/N' => $key+1, 
                'vendor_id' => $value['vendor_id'], 
                'application_id' => $value['id'], 
                'name_of_candidate' => $value['user']['firstname'] .' '.$value['user']['lastname'],
                'index_numbers' => $value['indexNumber']['arbitrary_1'] .'/'. $value['indexNumber']['arbitrary_2'] .'/'. $value['indexNumber']['batch_year'] .'/'. $value['indexNumber']['state_code'] .'/'. $value['indexNumber']['school_code'] .'/'. $value['indexNumber']['tier'] .'/'. $value['indexNumber']['id'],
                'tier' => $value['tier']['name'], 
                'batch' => $value['batch']['batch_no'].'/'.$value['batch']['year'], 
                'traning_centre' => $value['school']['name'], 
                'exam_score' => '', 
                'percentage_score' => '', 
            ];
            array_push($array, $fields);
        }

        $results = new ResultTemplateExport($array);

        return Excel::download($results, 'result-template.xlsx');
    }

    public function uploadResult(Request $request){

        $this->validate($request, [
            'result' => [
                'required'
            ]
        ]);

        try {
            DB::beginTransaction();

            $import = new ResultImport;

            Excel::import($import, request()->file('result'));

            $results = $import->getImportedData();

            foreach($results as $result){

                if($result['percentage_score'] >= 50 && $result['percentage_score'] <= 100){
                    $status = 'pass';
                }
                if($result['percentage_score'] <= 49 && $result['percentage_score'] >= 0){
                    $status = 'fail';
                }

                
                MEPTPApplication::where(['id' => $result['application_id'], 'vendor_id' => $result['vendor_id']])
                ->update([
                    'status' => $status
                ]);

                MEPTPResult::where(['application_id' => $result['application_id'], 'vendor_id' => $result['vendor_id']])
                ->update([
                    'status' => $status,
                    'score' => $result['exam_score_50'],
                    'percentage' => $result['percentage_score']
                ]);

                $application = MEPTPResult::where(['application_id' => $result['application_id'], 'vendor_id' => $result['vendor_id']])
                ->with('user')
                ->first();

                $data = [
                    'vendor' => $application->user
                ];
                MEPTPExamResultEmailJOB::dispatch($data);


                $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                $activity = 'MEPTP Examination Result Uploaded';
                AllActivity::storeActivity($result['application_id'], $adminName, $activity, 'meptp');
            }

            

            DB::commit();

            return back()->with('success', 'Results uploaded successfully done');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }

    
}
