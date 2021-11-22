<?php

namespace App\Http\Controllers\Registry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;
use DB;

class DoumentRecommendationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $documents = Registration::where(['payment' => true])
        ->with('hospital_pharmacy', 'ppmv', 'other_registration', 'user')
        ->where('location_approval', false)
        ->where(function($q){
            $q->where('status', 'partial_recommendation');
            $q->orWhere('status', 'full_recommendation');
            $q->orWhere('status', 'facility_full_recommendation');
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

        return view('registry.recommendation.index', compact('documents'));
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

    public function hospitalPharmacyShow(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'hospital_pharmacy'])
        ->with('hospital_pharmacy', 'user')
        ->where(function($q){
            $q->where('status', 'partial_recommendation');
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
                    'download-link' => route('hospital-inspection-report-download', $registration->id),
                ];
            }
            if($registration->status == 'partial_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: Partial Recommendation',
                    'color' => 'success',
                    'download-link' => route('hospital-inspection-report-download', $registration->id),
                ];
            }
            if($registration->status == 'full_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: Full Recommendation',
                    'color' => 'success',
                    'download-link' => route('hospital-inspection-report-download', $registration->id),
                ];
            }
            return view('registry.recommendation.hospital-show', compact('registration', 'alert'));
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
                    ->with('user', 'other_registration.company')
                    ->where(function($q){
                        $q->where('status', 'partial_recommendation');
                        $q->orWhere('status', 'full_recommendation');
                        $q->orWhere('status', 'facility_full_recommendation');
                    })
                    ->first();

                    if($Registration->type == 'hospital_pharmacy'){
                        Registration::where(['payment' => true, 'id' => $registration_id])
                        ->where(function($q){
                            $q->where('status', 'partial_recommendation');
                            $q->orWhere('status', 'full_recommendation');
                        })
                        ->update([
                            'status' => 'send_to_registration'
                        ]);

                        // Store Report 
                        \App\Http\Services\Reports::storeApplicationReport($Registration->id, 'hospital_pharmacy', 'facility_inspection', 'approved', $Registration->user->state);
                    }
                    if($Registration->type == 'ppmv'){
                        Registration::where(['payment' => true, 'id' => $registration_id])
                        ->where(function($q){
                            $q->where('status', 'facility_full_recommendation');
                        })
                        ->update([
                            'status' => 'facility_send_to_registration'
                        ]);

                        // Store Report 
                        \App\Http\Services\Reports::storeApplicationReport($Registration->id, 'ppmv', 'facility_inspection', 'approved', $Registration->user->state);
                    }
                    if($Registration->type == 'community_pharmacy'){
                        Registration::where(['payment' => true, 'id' => $registration_id])
                        ->where(function($q){
                            $q->where('status', 'facility_full_recommendation');
                        })
                        ->update([
                            'status' => 'facility_send_to_registration'
                        ]);

                        // Store Report 
                        \App\Http\Services\Reports::storeApplicationReport($Registration->id, 'community_pharmacy', 'facility_inspection', 'approved', $Registration->other_registration->company->state);
                    }
                    if($Registration->type == 'distribution_premises'){
                        Registration::where(['payment' => true, 'id' => $registration_id])
                        ->where(function($q){
                            $q->where('status', 'facility_full_recommendation');
                        })
                        ->update([
                            'status' => 'facility_send_to_registration'
                        ]);

                        // Store Report 
                        \App\Http\Services\Reports::storeApplicationReport($Registration->id, 'distribution_premises', 'facility_inspection', 'approved', $Registration->other_registration->company->state);
                    }
                    if($Registration->type == 'manufacturing_premises'){
                        Registration::where(['payment' => true, 'id' => $registration_id])
                        ->where(function($q){
                            $q->where('status', 'facility_full_recommendation');
                        })
                        ->update([
                            'status' => 'facility_send_to_registration'
                        ]);

                        // Store Report 
                        \App\Http\Services\Reports::storeApplicationReport($Registration->id, 'manufacturing_premises', 'facility_inspection', 'approved', $Registration->other_registration->company->state);
                    }

                    $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                    $activity = 'Registry Document Facility Inspection Report Approval';
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

    public function hospitalPharmacyApprove(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'hospital_pharmacy'])
        ->where(function($q){
            $q->where('status', 'partial_recommendation');
            $q->orWhere('status', 'full_recommendation');
        })
        ->with('user')
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'hospital_pharmacy'])
            ->where(function($q){
                $q->where('status', 'partial_recommendation');
                $q->orWhere('status', 'full_recommendation');
            })
            ->update([
                'status' => 'send_to_registration'
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'Registry Document Facility Inspection Report Approval';
            AllActivity::storeActivity($request['registration_id'], $adminName, $activity, 'hospital_pharmacy');

            // Store Report 
            \App\Http\Services\Reports::storeApplicationReport($registration->id, 'hospital_pharmacy', 'facility_inspection', 'approved', $registration->user->state);

            return redirect()->route('registry-recommendation.index')->with('success', 'Registration Approved successfully done');
        }else{
            return abort(404);
        }
    }


    public function ppmvRegistrationShow(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
        ->with('ppmv', 'user')
        ->where(function($q){
            $q->where('status', 'facility_full_recommendation');
        })
        ->first();

        if($registration){
            $alert = [];
            if($registration->status == 'facility_no_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: No Recommendation',
                    'color' => 'danger',
                    'download-link' => route('ppmv-registration-inspection-report-download', $registration->id),
                ];
            }
            if($registration->status == 'facility_full_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: Full Recommendation',
                    'color' => 'success',
                    'download-link' => route('ppmv-registration-inspection-report-download', $registration->id),
                ];
            }
            return view('registry.recommendation.ppmv-registration-show', compact('registration', 'alert'));
        }else{
            return abort(404);
        }
    }

    public function ppmvRegistrationApprove(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
        ->where(function($q){
            $q->where('status', 'facility_full_recommendation');
        })
        ->with('user')
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
            ->where(function($q){
                $q->where('status', 'facility_full_recommendation');
            })
            ->update([
                'status' => 'facility_send_to_registration'
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'Registry Document Facility Inspection Report Approval';
            AllActivity::storeActivity($request['registration_id'], $adminName, $activity, 'ppmv');

            // Store Report 
            \App\Http\Services\Reports::storeApplicationReport($registration->id, 'ppmv', 'facility_inspection', 'approved', $registration->user->state);

            return redirect()->route('registry-recommendation.index')->with('success', 'Registration Approved successfully done');
        }else{
            return abort(404);
        }
    }




    public function communityRegistrationShow(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy'])
        ->with('other_registration', 'user')
        ->where(function($q){
            $q->where('status', 'facility_full_recommendation');
        })
        ->first();

        if($registration){
            $alert = [];
            if($registration->status == 'facility_no_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: No Recommendation',
                    'color' => 'danger',
                    'download-link' => route('location-inspection-report-download', $registration->id),
                ];
            }
            if($registration->status == 'facility_full_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: Full Recommendation',
                    'color' => 'success',
                    'download-link' => route('location-inspection-report-download', $registration->id),
                ];
            }
            return view('registry.recommendation.community-show', compact('registration', 'alert'));
        }else{
            return abort(404);
        }
    }

    public function communityRegistrationApprove(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy'])
        ->where(function($q){
            $q->where('status', 'facility_full_recommendation');
        })
        ->with('user', 'other_registration.company')
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy'])
            ->where(function($q){
                $q->where('status', 'facility_full_recommendation');
            })
            ->update([
                'status' => 'facility_send_to_registration'
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'Registry Document Facility Inspection Report Approval';
            AllActivity::storeActivity($request['registration_id'], $adminName, $activity, 'community_pharmacy');

             // Store Report 
             \App\Http\Services\Reports::storeApplicationReport($registration->id, 'community_pharmacy', 'facility_inspection', 'approved', $registration->other_registration->company->state);

            return redirect()->route('registry-recommendation.index')->with('success', 'Registration Approved successfully done');
        }else{
            return abort(404);
        }
    }



    public function distributionRegistrationShow(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises'])
        ->with('other_registration', 'user')
        ->where(function($q){
            $q->where('status', 'facility_full_recommendation');
        })
        ->first();

        if($registration){
            $alert = [];
            if($registration->status == 'facility_no_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: No Recommendation',
                    'color' => 'danger',
                    'download-link' => route('location-inspection-report-download', $registration->id),
                ];
            }
            if($registration->status == 'facility_full_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: Full Recommendation',
                    'color' => 'success',
                    'download-link' => route('location-inspection-report-download', $registration->id),
                ];
            }
            return view('registry.recommendation.distribution-show', compact('registration', 'alert'));
        }else{
            return abort(404);
        }
    }

    public function distributionRegistrationApprove(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises'])
        ->where(function($q){
            $q->where('status', 'facility_full_recommendation');
        })
        ->with('user', 'other_registration.company')
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises'])
            ->where(function($q){
                $q->where('status', 'facility_full_recommendation');
            })
            ->update([
                'status' => 'facility_send_to_registration'
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'Registry Document Facility Inspection Report Approval';
            AllActivity::storeActivity($request['registration_id'], $adminName, $activity, 'distribution_premises');

            // Store Report 
            \App\Http\Services\Reports::storeApplicationReport($registration->id, 'distribution_premises', 'facility_inspection', 'approved', $registration->other_registration->company->state);

            return redirect()->route('registry-recommendation.index')->with('success', 'Registration Approved successfully done');
        }else{
            return abort(404);
        }
    }


    public function manufacturingRegistrationShow(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'manufacturing_premises'])
        ->with('other_registration', 'user')
        ->where(function($q){
            $q->where('status', 'facility_full_recommendation');
        })
        ->first();

        if($registration){
            $alert = [];
            if($registration->status == 'facility_no_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: No Recommendation',
                    'color' => 'danger',
                    'download-link' => route('location-inspection-report-download', $registration->id),
                ];
            }
            if($registration->status == 'facility_full_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: Full Recommendation',
                    'color' => 'success',
                    'download-link' => route('location-inspection-report-download', $registration->id),
                ];
            }
            return view('registry.recommendation.manufacturing-show', compact('registration', 'alert'));
        }else{
            return abort(404);
        }
    }

    public function manufacturingRegistrationApprove(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'manufacturing_premises'])
        ->where(function($q){
            $q->where('status', 'facility_full_recommendation');
        })
        ->with('user', 'other_registration.company')
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'manufacturing_premises'])
            ->where(function($q){
                $q->where('status', 'facility_full_recommendation');
            })
            ->update([
                'status' => 'facility_send_to_registration'
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'Registry Document Facility Inspection Report Approval';
            AllActivity::storeActivity($request['registration_id'], $adminName, $activity, 'manufacturing_premises');

            // Store Report 
            \App\Http\Services\Reports::storeApplicationReport($registration->id, 'manufacturing_premises', 'facility_inspection', 'approved', $registration->other_registration->company->state);

            return redirect()->route('registry-recommendation.index')->with('success', 'Registration Approved successfully done');
        }else{
            return abort(404);
        }
    }
}
