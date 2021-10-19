<?php

namespace App\Http\Controllers\Registry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use App\Models\Renewal;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;
use DB;

class RenewalInspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $documents = Renewal::where(['payment' => true])
        ->with('hospital_pharmacy', 'registration', 'other_registration', 'user')
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

        return view('registry.renewal-pending.index', compact('documents'));
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

        $registration = Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'hospital_pharmacy_renewal'])
        ->with('hospital_pharmacy', 'registration', 'user')
        ->where('status', 'send_to_registry')
        ->first();

        if($registration){
            return view('registry.renewal-pending.hospital-show', compact('registration'));
        }else{
            return abort(404);
        }
    }

    public function ApproveAll(Request $request){
        try {
            DB::beginTransaction();

            $checkboxes = isset($request->check_box_bulk_action) ? true : false;

            if($checkboxes == true){
                foreach($request->check_box_bulk_action as $renewal_id => $newRenewal){


                    $renewal = Renewal::where(['payment' => true, 'id' => $renewal_id])
                    ->with('hospital_pharmacy', 'registration', 'other_registration', 'user')
                    ->where('status', 'send_to_registry')
                    ->first();

                    if($renewal){

                        if($renewal->type == 'hospital_pharmacy_renewal'){

                            Renewal::where(['payment' => true, 'id' => $renewal_id, 'user_id' => $renewal->user_id])
                            ->where('status', 'send_to_registry')
                            ->update([
                                'status' => 'send_to_pharmacy_practice'
                            ]);
                            
                            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                            $activity = 'Registry Renewal Inspection Approve';
                            AllActivity::storeActivity($renewal_id, $adminName, $activity, 'hospital_pharmacy');

                        }

                        if($renewal->type == 'ppmv_renewal'){

                            Renewal::where(['payment' => true, 'id' => $renewal_id, 'user_id' => $renewal->user_id])
                            ->where('status', 'send_to_registry')
                            ->update([
                                'status' => 'send_to_pharmacy_practice'
                            ]);
                            
                            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                            $activity = 'Registry Renewal Inspection Approve';
                            AllActivity::storeActivity($renewal_id, $adminName, $activity, 'ppmv');

                        }

                        if($renewal->type == 'community_pharmacy_renewal'){

                            Renewal::where(['payment' => true, 'id' => $renewal_id, 'user_id' => $renewal->user_id])
                            ->where('status', 'send_to_registry')
                            ->update([
                                'status' => 'send_to_inspection_monitoring'
                            ]);
                            
                            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                            $activity = 'Registry Renewal Inspection Approve';
                            AllActivity::storeActivity($renewal_id, $adminName, $activity, 'community_pharmacy');

                        }

                        if($renewal->type == 'distribution_premises_renewal'){

                            Renewal::where(['payment' => true, 'id' => $renewal_id, 'user_id' => $renewal->user_id])
                            ->where('status', 'send_to_registry')
                            ->update([
                                'status' => 'send_to_inspection_monitoring'
                            ]);
                            
                            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                            $activity = 'Registry Renewal Inspection Approve';
                            AllActivity::storeActivity($renewal_id, $adminName, $activity, 'distribution_premises');

                        }


                    }else{
                        return abort(404);
                    }

                }
                $response = true;
            }else{
                $response = false;
            }

        DB::commit();

            if($response == true){
                return back()->with('success', 'Licence issued successfully done.');
            }else{
                return back()->with('error', 'Please select atleast one registration.');
            }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }

    }

    public function hospitalPharmacyApprove(Request $request){

        try {
            DB::beginTransaction();

                $renewal = Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'hospital_pharmacy_renewal'])
                ->with('hospital_pharmacy', 'registration', 'user')
                ->where('status', 'send_to_registry')
                ->first();

                if($renewal){

                    Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'hospital_pharmacy_renewal'])
                    ->where('status', 'send_to_registry')
                    ->update([
                        'status' => 'send_to_pharmacy_practice'
                    ]);
                    
                    $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                    $activity = 'Registry Renewal Inspection Approve';
                    AllActivity::storeActivity($request['registration_id'], $adminName, $activity, 'hospital_pharmacy');

                }else{
                    return abort(404);
                }

        DB::commit();
            return redirect()->route('registry-renewal-pending.index')->with('success', 'Licence issued successfully done');
        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }
    }

    public function ppmvShow(Request $request){

        $registration = Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv_renewal'])
        ->with('ppmv', 'registration', 'user')
        ->where('status', 'send_to_registry')
        ->first();

        if($registration){
            return view('registry.renewal-pending.ppmv-renewal-show', compact('registration'));
        }else{
            return abort(404);
        }
    }

    public function ppmvApprove(Request $request){

        try {
            DB::beginTransaction();

                $renewal = Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv_renewal'])
                ->with('ppmv', 'registration', 'user')
                ->where('status', 'send_to_registry')
                ->first();

                if($renewal){

                    Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv_renewal'])
                    ->where('status', 'send_to_registry')
                    ->update([
                        'status' => 'send_to_pharmacy_practice'
                    ]);
                    
                    $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                    $activity = 'Registry Renewal Inspection Approve';
                    AllActivity::storeActivity($request['registration_id'], $adminName, $activity, 'ppmv');

                }else{
                    return abort(404);
                }

        DB::commit();
            return redirect()->route('registry-renewal-pending.index')->with('success', 'Licence issued successfully done');
        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }
    }


    public function communityShow(Request $request){

        $registration = Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy_renewal'])
        ->with('registration', 'other_registration', 'user')
        ->where('status', 'send_to_registry')
        ->first();
        
        if($registration){
            return view('registry.renewal-pending.community-renewal-show', compact('registration'));
        }else{
            return abort(404);
        }
    }

    public function communityApprove(Request $request){

        try {
            DB::beginTransaction();

                $renewal = Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy_renewal'])
                ->with('ppmv', 'registration', 'user')
                ->where('status', 'send_to_registry')
                ->first();

                if($renewal){

                    Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy_renewal'])
                    ->where('status', 'send_to_registry')
                    ->update([
                        'status' => 'send_to_inspection_monitoring'
                    ]);
                    
                    $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                    $activity = 'Registry Renewal Inspection Approve';
                    AllActivity::storeActivity($request['registration_id'], $adminName, $activity, 'community_pharmacy');

                }else{
                    return abort(404);
                }

        DB::commit();
            return redirect()->route('registry-renewal-pending.index')->with('success', 'Licence issued successfully done');
        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }
    }

    public function distributionShow(Request $request){

        $registration = Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises_renewal'])
        ->with('registration', 'other_registration', 'user')
        ->where('status', 'send_to_registry')
        ->first();
        
        if($registration){
            return view('registry.renewal-pending.distribution-renewal-show', compact('registration'));
        }else{
            return abort(404);
        }
    }

    public function distributionApprove(Request $request){

        try {
            DB::beginTransaction();

                $renewal = Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises_renewal'])
                ->with('ppmv', 'registration', 'user')
                ->where('status', 'send_to_registry')
                ->first();

                if($renewal){

                    Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises_renewal'])
                    ->where('status', 'send_to_registry')
                    ->update([
                        'status' => 'send_to_inspection_monitoring'
                    ]);
                    
                    $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                    $activity = 'Registry Renewal Inspection Approve';
                    AllActivity::storeActivity($request['registration_id'], $adminName, $activity, 'distribution_premises');

                }else{
                    return abort(404);
                }

        DB::commit();
            return redirect()->route('registry-renewal-pending.index')->with('success', 'Licence issued successfully done');
        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }
    }
}
