<?php

namespace App\Http\Controllers\InspectionMonitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\OtherRegistration;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;
use DB;
use App\Jobs\EmailSendJOB;

class FacilityInspectionPendingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $documents = Registration::where(['payment' => true])
        ->with('other_registration', 'user')
        ->where('location_approval', false)
        ->whereIn('type', ['community_pharmacy', 'distribution_premises', 'manufacturing_premises'])
        ->where('status', 'send_to_inspection_monitoring_registration');
        
        if($request->per_page){
            $perPage = (integer) $request->per_page;
        }else{
            $perPage = 10;
        }

        if(!empty($request->search)){
            $search = $request->search;
            $documents = $documents->where(function($q) use ($search){
                $q->where('documents.type', 'like', '%' .$search. '%');
                $q->orWhere('documents.category', 'like', '%' .$search. '%');
            });
        }

        $documents = $documents->latest()->paginate($perPage);

        return view('inspectionmonitoring.facility-pending.index', compact('documents'));
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


    public function communityShow(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy'])
        ->with('other_registration', 'user')
        ->where('status', 'send_to_inspection_monitoring_registration')
        ->first();

        if($registration){
            return view('inspectionmonitoring.facility-pending.community-show', compact('registration'));
        }else{
            return abort(404);
        }
    }

    public function communityUpdate(Request $request){

        $this->validate($request, [
            'recommendation' => ['required'],
            'report' => ['required']
        ]);

        try {
            DB::beginTransaction();

            $Registration = Registration::where(['id' => $request->registration_id, 'user_id' => $request->user_id, 'type' => 'community_pharmacy'])
            ->where('status', 'send_to_inspection_monitoring_registration')
            ->where('payment', true)
            ->with('other_registration.company', 'user')
            ->first();

            if($Registration){

                $file = $request->file('report');

                $private_storage_path = storage_path(
                    'app'. DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . $Registration->user_id . DIRECTORY_SEPARATOR . 'company'
                );

                if(!file_exists($private_storage_path)){
                    \mkdir($private_storage_path, intval('755',8), true);
                }
                $file_name = 'user'.$Registration->user_id.'-inspection_report.'.$file->getClientOriginalExtension();
                $file->move($private_storage_path, $file_name);

                Registration::where(['id' => $request->registration_id, 'user_id' => $request->user_id, 'type' => 'community_pharmacy'])
                ->where('status', 'send_to_inspection_monitoring_registration')
                ->where('payment', true)
                ->update([
                    'status' => $request->recommendation,
                    'inspection_report' => $file_name,
                ]);


                $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;

                if($request->recommendation == 'facility_no_recommendation'){
                    $activity = 'Facility Inspection Report Uploaded';

                    $data = [
                        'user' => $Registration->user,
                        'registration_type' => 'community_pharmacy_registration',
                        'type' => 'inspection_recommendation',
                        'status' => 'no_recommendation',
                    ];
                    EmailSendJOB::dispatch($data);

                    // Store Report 
                    \App\Http\Services\Reports::storeApplicationReport($Registration->id, 'community_pharmacy', 'facility_inspection', 'queried', $Registration->other_registration->company->state, Auth::user()->id);
                }
                if($request->recommendation == 'facility_full_recommendation'){
                    $activity = 'Facility Inspection Report Uploaded';

                    $data = [
                        'user' => $Registration->user,
                        'registration_type' => 'community_pharmacy_registration',
                        'type' => 'inspection_recommendation',
                        'status' => 'full_recommendation',
                    ];
                    EmailSendJOB::dispatch($data);
                }
                AllActivity::storeActivity($Registration->id, $adminName, $activity, 'community_pharmacy');

            }else{
                return abort(404);
            }
            
            DB::commit();

            return redirect()->route('monitoring-inspection-flt.index')
            ->with('success', 'Inspection Report updated successfully');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }


    public function distributionShow(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises'])
        ->with('other_registration', 'user')
        ->where('status', 'send_to_inspection_monitoring_registration')
        ->first();

        if($registration){
            return view('inspectionmonitoring.facility-pending.distribution-show', compact('registration'));
        }else{
            return abort(404);
        }
    }

    public function distributionUpdate(Request $request){

        $this->validate($request, [
            'recommendation' => ['required'],
            'report' => ['required']
        ]);

        try {
            DB::beginTransaction();

            $Registration = Registration::where(['id' => $request->registration_id, 'user_id' => $request->user_id, 'type' => 'distribution_premises'])
            ->where('status', 'send_to_inspection_monitoring_registration')
            ->where('payment', true)
            ->with('other_registration.company', 'user')
            ->first();

            if($Registration){

                $file = $request->file('report');

                $private_storage_path = storage_path(
                    'app'. DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . $Registration->user_id . DIRECTORY_SEPARATOR . 'company'
                );

                if(!file_exists($private_storage_path)){
                    \mkdir($private_storage_path, intval('755',8), true);
                }
                $file_name = 'user'.$Registration->user_id.'-inspection_report.'.$file->getClientOriginalExtension();
                $file->move($private_storage_path, $file_name);

                Registration::where(['id' => $request->registration_id, 'user_id' => $request->user_id, 'type' => 'distribution_premises'])
                ->where('status', 'send_to_inspection_monitoring_registration')
                ->where('payment', true)
                ->update([
                    'status' => $request->recommendation,
                    'inspection_report' => $file_name,
                ]);


                $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;

                if($request->recommendation == 'facility_no_recommendation'){
                    $activity = 'Facility Inspection Report Uploaded';

                    $data = [
                        'user' => $Registration->user,
                        'registration_type' => 'distribution_premises_registration',
                        'type' => 'inspection_recommendation',
                        'status' => 'no_recommendation',
                    ];
                    EmailSendJOB::dispatch($data);

                    // Store Report 
                    \App\Http\Services\Reports::storeApplicationReport($Registration->id, 'distribution_premises', 'facility_inspection', 'queried', $Registration->other_registration->company->state, Auth::user()->id);
                }
                if($request->recommendation == 'facility_full_recommendation'){
                    $activity = 'Facility Inspection Report Uploaded';

                    $data = [
                        'user' => $Registration->user,
                        'registration_type' => 'distribution_premises_registration',
                        'type' => 'inspection_recommendation',
                        'status' => 'full_recommendation',
                    ];
                    EmailSendJOB::dispatch($data);
                }
                AllActivity::storeActivity($Registration->id, $adminName, $activity, 'distribution_premises');

            }else{
                return abort(404);
            }
            
            DB::commit();

            return redirect()->route('monitoring-inspection-flt.index')
            ->with('success', 'Inspection Report updated successfully');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }

    public function manufacturingShow(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'manufacturing_premises'])
        ->with('other_registration', 'user')
        ->where('status', 'send_to_inspection_monitoring_registration')
        ->first();

        if($registration){
            return view('inspectionmonitoring.facility-pending.manufacturing-show', compact('registration'));
        }else{
            return abort(404);
        }
    }

    public function manufacturingUpdate(Request $request){

        $this->validate($request, [
            'recommendation' => ['required'],
            'report' => ['required']
        ]);

        try {
            DB::beginTransaction();

            $Registration = Registration::where(['id' => $request->registration_id, 'user_id' => $request->user_id, 'type' => 'manufacturing_premises'])
            ->where('status', 'send_to_inspection_monitoring_registration')
            ->where('payment', true)
            ->with('other_registration.company', 'user')
            ->first();

            if($Registration){

                $file = $request->file('report');

                $private_storage_path = storage_path(
                    'app'. DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . $Registration->user_id . DIRECTORY_SEPARATOR . 'company'
                );

                if(!file_exists($private_storage_path)){
                    \mkdir($private_storage_path, intval('755',8), true);
                }
                $file_name = 'user'.$Registration->user_id.'-inspection_report.'.$file->getClientOriginalExtension();
                $file->move($private_storage_path, $file_name);

                Registration::where(['id' => $request->registration_id, 'user_id' => $request->user_id, 'type' => 'manufacturing_premises'])
                ->where('status', 'send_to_inspection_monitoring_registration')
                ->where('payment', true)
                ->update([
                    'status' => $request->recommendation,
                    'inspection_report' => $file_name,
                ]);


                $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;

                if($request->recommendation == 'facility_no_recommendation'){
                    $activity = 'Facility Inspection Report Uploaded';

                    $data = [
                        'user' => $Registration->user,
                        'registration_type' => 'manufacturing_premises_registration',
                        'type' => 'inspection_recommendation',
                        'status' => 'no_recommendation',
                    ];
                    EmailSendJOB::dispatch($data);

                    // Store Report 
                    \App\Http\Services\Reports::storeApplicationReport($Registration->id, 'manufacturing_premises', 'facility_inspection', 'queried', $Registration->other_registration->company->state, Auth::user()->id);
                }
                if($request->recommendation == 'facility_full_recommendation'){
                    $activity = 'Facility Inspection Report Uploaded';

                    $data = [
                        'user' => $Registration->user,
                        'registration_type' => 'manufacturing_premises_registration',
                        'type' => 'inspection_recommendation',
                        'status' => 'full_recommendation',
                    ];
                    EmailSendJOB::dispatch($data);
                }
                AllActivity::storeActivity($Registration->id, $adminName, $activity, 'manufacturing_premises');

            }else{
                return abort(404);
            }
            
            DB::commit();

            return redirect()->route('monitoring-inspection-flt.index')
            ->with('success', 'Inspection Report updated successfully');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }
}
