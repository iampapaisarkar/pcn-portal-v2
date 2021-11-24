<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;
use DB;
use App\Jobs\EmailSendJOB;

class LocationInspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $applications = Registration::where(['payment' => true])
        ->with('ppmv', 'user')
        ->where('location_approval', true)
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->where('status', 'send_to_state_office_inspection');
        
        if($request->per_page){
            $perPage = (integer) $request->per_page;
        }else{
            $perPage = 10;
        }

        if(!empty($request->search)){
            $search = $request->search;
            $applications = $applications->where(function($q) use ($search){
                $q->where('documents.type', 'like', '%' .$search. '%');
                $q->orWhere('documents.category', 'like', '%' .$search. '%');
            });
        }

        $applications = $applications->latest()->paginate($perPage);

        return view('stateoffice.location-inspection.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ppmvLocationShow(Request $request){

        $application = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
        ->with('ppmv', 'user')
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->where('status', 'send_to_state_office_inspection')
        ->first();

        if($application){
            return view('stateoffice.location-inspection.ppmv-location-show', compact('application'));
        }else{
            return abort(404);
        }
    }

    public function ppmvLocationInspectionupdate(Request $request){

        $this->validate($request, [
            'recommendation' => ['required'],
            'report' => ['required']
        ]);

        try {
            DB::beginTransaction();

            $Registration = Registration::where(['id' => $request->application_id, 'user_id' => $request->user_id, 'type' => 'ppmv'])
            ->where('status', 'send_to_state_office_inspection')
            ->where('payment', true)
            ->with('ppmv', 'user')
            ->whereHas('user', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->first();

            if($Registration){

                $file = $request->file('report');

                $private_storage_path = storage_path(
                    'app'. DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . $Registration->user_id . DIRECTORY_SEPARATOR . 'ppmv'
                );

                if(!file_exists($private_storage_path)){
                    \mkdir($private_storage_path, intval('755',8), true);
                }
                $file_name = 'user'.$Registration->user_id.'-inspection_report.'.$file->getClientOriginalExtension();
                $file->move($private_storage_path, $file_name);

                Registration::where(['id' => $request->application_id, 'user_id' => $request->user_id, 'type' => 'ppmv'])
                ->where('status', 'send_to_state_office_inspection')
                ->where('payment', true)
                ->whereHas('user', function($q){
                    $q->where('state', Auth::user()->state);
                })
                ->update([
                    'status' => $request->recommendation,
                    'inspection_report' => $file_name,
                ]);


                $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;

                if($request->recommendation == 'no_recommendation'){
                    $activity = 'Facility Inspection Report Uploaded';

                    $data = [
                        'user' => $Registration->user,
                        'registration_type' => 'ppmv',
                        'type' => 'state_recommendation',
                        'status' => 'no_recommendation',
                    ];
                    EmailSendJOB::dispatch($data);

                    // Store Report 
                    \App\Http\Services\Reports::storeApplicationReport($Registration->id, 'ppmv', 'location_inspection', 'queried', $Registration->user->state, Auth::user()->id);
                }
                // if($request->recommendation == 'partial_recommendation'){
                //     $activity = 'Facility Inspection Report Uploaded';

                //     // $data = [
                //     //     'user' => $Registration->user,
                //     //     'registration_type' => 'ppmv',
                //     //     'type' => 'state_recommendation',
                //     //     'status' => 'partial_recommendation',
                //     // ];
                //     // EmailSendJOB::dispatch($data);
                // }
                if($request->recommendation == 'full_recommendation'){
                    $activity = 'Facility Inspection Report Uploaded';

                    $data = [
                        'user' => $Registration->user,
                        'registration_type' => 'ppmv',
                        'type' => 'state_recommendation',
                        'status' => 'full_recommendation',
                    ];
                    EmailSendJOB::dispatch($data);
                }
                AllActivity::storeActivity($Registration->id, $adminName, $activity, 'ppmv');

            }else{
                return abort(404);
            }
            
            DB::commit();

            return redirect()->route('state-office-locations.index')
            ->with('success', 'Inspection Report updated successfully');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }
}
