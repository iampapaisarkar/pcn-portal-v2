<?php

namespace App\Http\Controllers\InspectionMonitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Renewal;
use App\Models\Registration;
use App\Models\OtherRegistration;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;
use DB;
use App\Jobs\EmailSendJOB;

class LocationInspectionRenewApprovedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $documents = Renewal::where(['payment' => true])
        ->with('other_registration', 'registration', 'user')
        ->whereIn('type', ['community_pharmacy', 'distribution_premises', 'manufacturing_premises'])
        ->where(function($q){
            $q->where('status', 'no_recommendation');
            $q->orWhere('status', 'full_recommendation');
        });
        
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
        
        return view('inspectionmonitoring.renewal-approved.index', compact('documents'));
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

        $registration = Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy_renewal'])
        ->with('other_registration', 'registration', 'user')
        ->where(function($q){
            $q->where('status', 'no_recommendation');
            $q->orWhere('status', 'full_recommendation');
        })
        ->first();

        if($registration){
            $alert = [];
            if($registration->status == 'no_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: No Recommendation',
                    'color' => 'danger',
                    'download-link' => route('location-inspection-report-download', $registration->registration->id),
                ];
            }
            if($registration->status == 'full_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: Full Recommendation',
                    'color' => 'success',
                    'download-link' => route('location-inspection-report-download', $registration->registration->id),
                ];
            }

            return view('inspectionmonitoring.renewal-approved.community-show', compact('registration', 'alert'));
        }else{
            return abort(404);
        }
    }

    public function distributionShow(Request $request){

        $registration = Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises_renewal'])
        ->with('other_registration', 'registration', 'user')
        ->where(function($q){
            $q->where('status', 'no_recommendation');
            $q->orWhere('status', 'full_recommendation');
        })
        ->first();

        if($registration){
            $alert = [];
            if($registration->status == 'no_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: No Recommendation',
                    'color' => 'danger',
                    'download-link' => route('location-inspection-report-download', $registration->registration->id),
                ];
            }
            if($registration->status == 'full_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: Full Recommendation',
                    'color' => 'success',
                    'download-link' => route('location-inspection-report-download', $registration->registration->id),
                ];
            }

            return view('inspectionmonitoring.renewal-approved.distribution-show', compact('registration', 'alert'));
        }else{
            return abort(404);
        }
    }

    public function manufacturingShow(Request $request){

        $registration = Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'manufacturing_premises_renewal'])
        ->with('other_registration', 'registration', 'user')
        ->where(function($q){
            $q->where('status', 'no_recommendation');
            $q->orWhere('status', 'full_recommendation');
        })
        ->first();

        if($registration){
            $alert = [];
            if($registration->status == 'no_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: No Recommendation',
                    'color' => 'danger',
                    'download-link' => route('location-inspection-report-download', $registration->registration->id),
                ];
            }
            if($registration->status == 'full_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: Full Recommendation',
                    'color' => 'success',
                    'download-link' => route('location-inspection-report-download', $registration->registration->id),
                ];
            }

            return view('inspectionmonitoring.renewal-approved.manufacturing-show', compact('registration', 'alert'));
        }else{
            return abort(404);
        }
    }
}
