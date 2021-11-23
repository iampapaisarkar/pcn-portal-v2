<?php

namespace App\Http\Controllers\Registry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;
use DB;

class DocumentInspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $documents = Registration::where(['payment' => true])
        ->with('hospital_pharmacy', 'user', 'other_registration')
        ->where('location_approval', false)
        ->where('status', 'send_to_registry');
        
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

        return view('registry.documents.index', compact('documents'));
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
        ->where('status', 'send_to_registry')
        ->first();

        if($registration){
            return view('registry.documents.hospital-show', compact('registration'));
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
                    ->with('user', 'other_registration.company')
                    ->first();

                    if($Registration->type == 'hospital_pharmacy'){
                        Registration::where(['payment' => true, 'id' => $registration_id])
                        ->where('status', 'send_to_registry')
                        ->update([
                            'status' => 'send_to_pharmacy_practice'
                        ]);
                        
                        // Store Report 
                        \App\Http\Services\Reports::storeApplicationReport($Registration->id, 'hospital_pharmacy', 'facility_inspection', 'pending', $Registration->user->state);
                    }
                    if($Registration->type == 'manufacturing_premises'){
                        Registration::where(['payment' => true, 'id' => $registration_id])
                        ->where('status', 'send_to_registry')
                        ->update([
                            'token' => md5(uniqid(rand(), true)),
                            'status' => 'send_to_inspection_monitoring_registration'
                        ]);

                        // Store Report 
                        \App\Http\Services\Reports::storeApplicationReport($Registration->id, 'manufacturing_premises', 'facility_inspection', 'pending', $Registration->other_registration->company->state);
                    }

                    $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                    $activity = 'Registry Document Facility Inspection Approval';
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
        ->where('status', 'send_to_registry')
        ->with('user')
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'hospital_pharmacy'])
            ->where('status', 'send_to_registry')
            ->update([
                'status' => 'send_to_pharmacy_practice'
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'Registry Document Facility Inspection Approval';
            AllActivity::storeActivity($request['registration_id'], $adminName, $activity, 'hospital_pharmacy');

            // Store Report 
            \App\Http\Services\Reports::storeApplicationReport($registration->id, 'hospital_pharmacy', 'facility_inspection', 'pending', $registration->user->state);

            return redirect()->route('registry-documents.index')->with('success', 'Registration Approved successfully done');
        }else{
            return abort(404);
        }
    }


    public function manufacturingShow(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'manufacturing_premises'])
        ->with('other_registration', 'user')
        ->where('status', 'send_to_registry')
        ->first();

        if($registration){
            return view('registry.documents.manufacturing-show', compact('registration'));
        }else{
            return abort(404);
        }
    }

    public function manufacturingApprove(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'manufacturing_premises'])
        ->where('status', 'send_to_registry')
        ->with('user', 'other_registration.company')
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'manufacturing_premises'])
            ->where('status', 'send_to_registry')
            ->update([
                'token' => md5(uniqid(rand(), true)),
                'status' => 'send_to_inspection_monitoring_registration'
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'Registry Document Facility Inspection Approval';
            AllActivity::storeActivity($request['registration_id'], $adminName, $activity, 'manufacturing_premises');

            // Store Report 
            \App\Http\Services\Reports::storeApplicationReport($registration->id, 'manufacturing_premises', 'facility_inspection', 'pending', $registration->other_registration->company->state);

            return redirect()->route('registry-documents.index')->with('success', 'Registration Approved successfully done');
        }else{
            return abort(404);
        }
    }
}
