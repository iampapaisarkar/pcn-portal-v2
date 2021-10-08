<?php

namespace App\Http\Controllers\Registry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;
use DB;

class LocationApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $applications = Registration::where(['payment' => true])
        ->with('ppmv', 'other_registration.company', 'user')
        ->where('location_approval', true)
        ->where('status', 'send_to_registry');
        
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

        return view('registry.location-applications.index', compact('applications'));
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
        ->where('status', 'send_to_registry')
        ->first();

        if($application){
            return view('registry.location-applications.ppmv-location-show', compact('application'));
        }else{
            return abort(404);
        }
    }

    public function ApproveAll(Request $request){
        try {
            DB::beginTransaction();

            $checkboxes = isset($request->check_box_bulk_action) ? true : false;

            if($checkboxes == true){
                foreach($request->check_box_bulk_action as $registration_id => $registration){

                    $Registration = Registration::where(['payment' => true, 'id' => $registration_id])
                    ->where('status', 'send_to_registry')
                    ->first();

                    if($Registration->type == 'ppmv'){
                        Registration::where(['payment' => true, 'id' => $registration_id])
                        ->where('status', 'send_to_registry')
                        ->update([
                            'status' => 'send_to_state_office_inspection'
                        ]);
                    }
                    if($Registration->type == 'community_pharmacy'){
                        Registration::where(['payment' => true, 'id' => $registration_id])
                        ->where('status', 'send_to_registry')
                        ->update([
                            'status' => 'send_to_inspection_monitoring'
                        ]);
                    }
                    if($Registration->type == 'distribution_premises'){
                        Registration::where(['payment' => true, 'id' => $registration_id])
                        ->where('status', 'send_to_registry')
                        ->update([
                            'status' => 'send_to_inspection_monitoring'
                        ]);
                    }

                    $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                    $activity = 'Registry Document Location Inspection Approval';
                    AllActivity::storeActivity($registration_id, $adminName, $activity, $Registration->type);

                }
                $response = true;
            }else{
                $response = false;
            }

        DB::commit();

            if($response == true){
                return back()->with('success', 'Registration approved successfully.');
            }else{
                return back()->with('error', 'Please select atleast one registration.');
            }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }

    }

    public function ppmvLocationApprove(Request $request){

        $application = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
        ->where('status', 'send_to_registry')
        ->first();

        if($application){
            Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
            ->where('status', 'send_to_registry')
            ->update([
                'status' => 'send_to_state_office_inspection'
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'Registry Document Location Inspection Approval';
            AllActivity::storeActivity($request['application_id'], $adminName, $activity, 'ppmv');

            return redirect()->route('registry-locations.index')->with('success', 'Application Approved successfully done');
        }else{
            return abort(404);
        }
    }


    public function communityLocationShow(Request $request){

        $application = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy'])
        ->with('other_registration.company', 'user')
        ->where('status', 'send_to_registry')
        ->first();

        if($application){
            return view('registry.location-applications.community-location-show', compact('application'));
        }else{
            return abort(404);
        }
    }

    public function communityLocationApprove(Request $request){

        $application = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy'])
        ->where('status', 'send_to_registry')
        ->first();

        if($application){
            Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy'])
            ->where('status', 'send_to_registry')
            ->update([
                'status' => 'send_to_inspection_monitoring'
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'Registry Document Location Inspection Approval';
            AllActivity::storeActivity($request['application_id'], $adminName, $activity, 'community_pharmacy');

            return redirect()->route('registry-locations.index')->with('success', 'Application Approved successfully done');
        }else{
            return abort(404);
        }
    }

    public function distributionLocationShow(Request $request){

        $application = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises'])
        ->with('other_registration.company', 'user')
        ->where('status', 'send_to_registry')
        ->first();

        if($application){
            return view('registry.location-applications.distribution-location-show', compact('application'));
        }else{
            return abort(404);
        }
    }

    public function distributionLocationApprove(Request $request){

        $application = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises'])
        ->where('status', 'send_to_registry')
        ->first();

        if($application){
            Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises'])
            ->where('status', 'send_to_registry')
            ->update([
                'status' => 'send_to_inspection_monitoring'
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'Registry Document Location Inspection Approval';
            AllActivity::storeActivity($request['application_id'], $adminName, $activity, 'distribution_premises');

            return redirect()->route('registry-locations.index')->with('success', 'Application Approved successfully done');
        }else{
            return abort(404);
        }
    }
}
