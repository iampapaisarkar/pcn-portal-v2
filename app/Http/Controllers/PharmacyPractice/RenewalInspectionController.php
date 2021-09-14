<?php

namespace App\Http\Controllers\PharmacyPractice;

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
        ->with('hospital_pharmacy', 'registration', 'user')
        ->where('status', 'send_to_pharmacy_practice');
        
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

        return view('pharmacypractice.renewal-pending.index', compact('documents'));
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
        ->where('status', 'send_to_pharmacy_practice')
        ->first();

        if($registration){
            return view('pharmacypractice.renewal-pending.hospital-show', compact('registration'));
        }else{
            return abort(404);
        }
    }

    public function hospitalPharmacyInspectionupdate(Request $request){

        $this->validate($request, [
            'recommendation' => ['required'],
            'report' => ['required']
        ]);

        try {
            DB::beginTransaction();

            $Registration = Registration::where(['id' => $request->registration_id, 'user_id' => $request->user_id, 'type' => 'hospital_pharmacy'])
            ->where('payment', true)
            ->with('hospital_pharmacy', 'user')
            ->first();

            $renewal = Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'hospital_pharmacy_renewal'])
            ->where('status', 'send_to_pharmacy_practice')
            ->first();

            if($renewal){

                $file = $request->file('report');

                $private_storage_path = storage_path(
                    'app'. DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . $Registration->user_id . DIRECTORY_SEPARATOR . 'hospital_pharmacy'
                );

                if(!file_exists($private_storage_path)){
                    \mkdir($private_storage_path, intval('755',8), true);
                }
                $file_name = 'user'.$Registration->user_id.'-inspection_report.'.$file->getClientOriginalExtension();
                $file->move($private_storage_path, $file_name);

                Registration::where(['id' => $request->registration_id, 'user_id' => $request->user_id, 'type' => 'hospital_pharmacy'])
                ->where('payment', true)
                ->update([
                    'inspection_report' => $file_name,
                ]);

                Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'hospital_pharmacy_renewal'])
                ->where('status', 'send_to_pharmacy_practice')
                ->update([
                    'status' => $request->recommendation
                ]);

                $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;

                if($request->recommendation == 'no_recommendation'){
                    $activity = 'Renewal Inspection Report Uploaded';
                }
                if($request->recommendation == 'partial_recommendation'){
                    $activity = 'Renewal Inspection Report Uploaded';
                }
                if($request->recommendation == 'full_recommendation'){
                    $activity = 'Renewal Inspection Report Uploaded';
                }
                AllActivity::storeActivity($Registration->id, $adminName, $activity, 'hospital_pharmacy');

            }else{
                return abort(404);
            }
            
            DB::commit();

            return redirect()->route('pharmacy-renewal-pending.index')
            ->with('success', 'Inspection Report updated successfully');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }
}
