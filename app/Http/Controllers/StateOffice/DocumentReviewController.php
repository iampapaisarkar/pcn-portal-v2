<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;

class DocumentReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $documents = Registration::where(['payment' => true])
        ->with('hospital_pharmacy', 'user')
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->where('status', 'send_to_state_office');
        
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

        return view('stateoffice.documents.index', compact('documents'));
       
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
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->where('status', 'send_to_state_office')
        ->first();

        if($registration){
            return view('stateoffice.documents.hospital-show', compact('registration'));
        }else{
            return abort(404);
        }
    }

    public function hospitalPharmacyApprove(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'hospital_pharmacy'])
        ->where('status', 'send_to_state_office')
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'hospital_pharmacy'])
            ->where('status', 'send_to_state_office')
            ->update([
                'status' => 'send_to_registry'
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'State Officer Document Verification Approval';
            AllActivity::storeActivity($request['registration_id'], $adminName, $activity, 'hospital_pharmacy');

            return redirect()->route('state-office-documents.index')->with('success', 'Registration Approved successfully done');
        }else{
            return abort(404);
        }
    }

    public function hospitalPharmacyReject(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'hospital_pharmacy'])
        ->where('status', 'send_to_state_office')
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'hospital_pharmacy'])
            ->where('status', 'send_to_state_office')
            ->whereHas('user', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->update([
                'status' => 'queried_by_state_office',
                'query' => $request['query'],
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'State Officer Document Verification Query';
            AllActivity::storeActivity($request['registration_id'], $adminName, $activity, 'hospital_pharmacy');

            return redirect()->route('state-office-documents.index')->with('success', 'Registration Queried successfully done');
        }else{
            return abort(404);
        }
    }
}
