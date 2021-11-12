<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use App\Models\Renewal;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;
use DB;

class RenewalReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $documents = Renewal::where(['payment' => true])
        ->with('ppmv', 'registration', 'user')
        ->where(function($q){
            $q->where('status', 'no_recommendation');
            $q->orWhere('status', 'partial_recommendation');
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
        
        return view('stateoffice.renewal-report.index', compact('documents'));
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

    public function ppmvShow(Request $request){

        $registration = Renewal::where(['payment' => true, 'id' => $request['renewal_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv_renewal'])
        ->with('ppmv', 'registration', 'user')
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
                    'download-link' => route('ppmv-registration-inspection-report-download', $registration->registration->id),
                ];
            }
            if($registration->status == 'partial_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: Partial Recommendation',
                    'color' => 'success',
                    'download-link' => route('ppmv-registration-inspection-report-download', $registration->registration->id),
                ];
            }
            if($registration->status == 'full_recommendation'){
                $alert = [
                    'success' => true,
                    'message' => 'Inspection Report: Full Recommendation',
                    'color' => 'success',
                    'download-link' => route('ppmv-registration-inspection-report-download', $registration->registration->id),
                ];
            }

            return view('stateoffice.renewal-report.ppmv-renewal-show', compact('registration', 'alert'));
        }else{
            return abort(404);
        }
    }
}
