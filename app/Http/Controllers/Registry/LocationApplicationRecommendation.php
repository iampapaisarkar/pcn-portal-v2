<?php

namespace App\Http\Controllers\Registry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;
use DB;

class LocationApplicationRecommendation extends Controller
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
        ->where(function($q){
            $q->where('status', 'full_recommendation');
        });
        
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

        return view('registry.location-recommendation.index', compact('applications'));
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

    public function ppmvLocationRecommendationShow(Request $request){

        $application = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
        ->with('ppmv', 'user')
        ->where(function($q){
            $q->where('status', 'full_recommendation');
        })
        ->first();

        if($application){
            if($application->status == 'no_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: No Recommendation',
                    'color' => 'danger',
                    'download-link' => route('ppmv-location-inspection-report-download', $application->id),
                ];
            }
            // if($application->status == 'partial_recommendation'){
            //     $alert = [
            //         'success' => true,
            //         'message' => 'Inspection Report: Partial Recommendation',
            //         'color' => 'success',
            //         'download-link' => route('ppmv-location-inspection-report-download', $application->id),
            //     ];
            // }
            if($application->status == 'full_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: Full Recommendation',
                    'color' => 'success',
                    'download-link' => route('ppmv-location-inspection-report-download', $application->id),
                ];
            }
            return view('registry.location-recommendation.ppmv-location-show', compact('application', 'alert'));
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
                    ->where(function($q){
                        $q->where('status', 'full_recommendation');
                    })
                    ->first();

                    if($Registration->type == 'ppmv'){
                        Registration::where(['payment' => true, 'id' => $registration_id])
                        ->where(function($q){
                            $q->where('status', 'full_recommendation');
                        })
                        ->update([
                            'status' => 'inspection_approved'
                        ]);
                    }

                    $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                    $activity = 'Registry Location Inspection Report Approval';
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

    public function ppmvLocationRecommendationApprove(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
        ->where(function($q){
            $q->where('status', 'full_recommendation');
        })
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
            ->where(function($q){
                $q->where('status', 'full_recommendation');
            })
            ->update([
                'status' => 'inspection_approved'
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'Registry Location Inspection Report Approval';
            AllActivity::storeActivity($request['application_id'], $adminName, $activity, 'ppmv');

            return redirect()->route('registry-location-recommendation.index')->with('success', 'Application Approved successfully done');
        }else{
            return abort(404);
        }
    }
}
