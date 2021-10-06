<?php

namespace App\Http\Controllers\Licencing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use App\Models\PpmvLocationApplication;
use App\Models\Renewal;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;
use DB;
use App\Jobs\EmailSendJOB;

class DocumentPendingLicenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $documents = Registration::where(['payment' => true])
        ->with('hospital_pharmacy', 'ppmv', 'user')
        ->where(function($q){
            $q->where('status', 'send_to_registration');
            $q->orWhere('status', 'facility_send_to_registration');
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

        return view('licencing.pending.index', compact('documents'));
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
        ->where('status', 'send_to_registration')
        ->first();

        if($registration){
            return view('licencing.pending.hospital-show', compact('registration'));
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
                    // ->where('status', 'send_to_registration')
                    ->where(function($q){
                        $q->where('status', 'send_to_registration');
                        $q->orWhere('status', 'facility_send_to_registration');
                    })
                    ->first();

                    Registration::where(['payment' => true, 'id' => $registration_id])
                    ->where(function($q){
                        $q->where('status', 'send_to_registration');
                        $q->orWhere('status', 'facility_send_to_registration');
                    })
                    ->update([
                        'status' => 'licence_issued'
                    ]);

                    if($Registration->type == 'hospital_pharmacy'){

                        $HospitalRegistration = HospitalRegistration::where(['registration_id' => $registration_id, 'user_id' => $Registration->user_id])
                        ->with('user')
                        ->latest()->first();

                        $renewal = Renewal::create([
                            'user_id' => $Registration->user_id,
                            'registration_id' => $registration_id,
                            'form_id' => $HospitalRegistration->id,
                            'type' => 'hospital_pharmacy_renewal',
                            'renewal_year' => date('Y'),
                            'expires_at' => \Carbon\Carbon::now()->format('Y') .'-12-31',
                            'licence' => 'TEST2021',
                            'status' => 'licence_issued',
                            'renewal' => false,
                            'inspection' => true,
                            'payment' => true,
                        ]);

                        $data = [
                            'user' => $HospitalRegistration->user,
                            'registration_type' => 'hospital_pharmacy',
                            'type' => 'licencing_issued',
                        ];
                        EmailSendJOB::dispatch($data);

                    }

                    if($Registration->type == 'ppmv'){
                        $PpmvLocationApplication = PpmvLocationApplication::where(['registration_id' => $registration_id, 'user_id' => $Registration->user_id])
                        ->with('user')
                        ->latest()->first();

                        $renewal = Renewal::create([
                            'user_id' => $Registration->user_id,
                            'registration_id' => $registration_id,
                            'form_id' => $PpmvLocationApplication->id,
                            'type' => 'ppmv_renewal',
                            'renewal_year' => date('Y'),
                            'expires_at' => \Carbon\Carbon::now()->format('Y') .'-12-31',
                            'licence' => 'TEST2021',
                            'status' => 'licence_issued',
                            'renewal' => false,
                            'inspection' => true,
                            'payment' => true,
                        ]);

                        $data = [
                            'user' => $PpmvLocationApplication->user,
                            'registration_type' => 'ppmv',
                            'type' => 'licencing_issued',
                        ];
                        EmailSendJOB::dispatch($data);
                    }

                    $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                    $activity = 'Registration & Licencing Issued Licence';
                    AllActivity::storeActivity($registration_id, $adminName, $activity, 'hospital_pharmacy');

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

                $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'hospital_pharmacy'])
                ->where('status', 'send_to_registration')
                ->with('user')
                ->first();

                if($registration){
                    Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'hospital_pharmacy'])
                    ->where('status', 'send_to_registration')
                    ->update([
                        'status' => 'licence_issued'
                    ]);

                    $HospitalRegistration = HospitalRegistration::where(['registration_id' => $request['registration_id'], 'user_id' => $request['user_id']])->latest()->first();

                    $renewal = Renewal::create([
                        'user_id' => $registration->user_id,
                        'registration_id' => $registration->id,
                        'form_id' => $HospitalRegistration->id,
                        'type' => 'hospital_pharmacy_renewal',
                        'renewal_year' => date('Y'),
                        'expires_at' => \Carbon\Carbon::now()->format('Y') .'-12-31',
                        'licence' => 'TEST2021',
                        'status' => 'licence_issued',
                        // 'renewal' => true,
                        // 'inspection' => true,
                        'payment' => true,
                    ]);

                    $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                    $activity = 'Registration & Licencing Issued Licence';
                    AllActivity::storeActivity($request['registration_id'], $adminName, $activity, 'hospital_pharmacy');

                    $data = [
                        'user' => $registration->user,
                        'registration_type' => 'hospital_pharmacy',
                        'type' => 'licencing_issued',
                    ];
                    EmailSendJOB::dispatch($data);

                }else{
                    return abort(404);
                }

        DB::commit();
            return redirect()->route('licence-pending.index')->with('success', 'Licence issued successfully done');
        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }
    }


    public function ppmvShow(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
        ->with('ppmv', 'user')
        ->where('status', 'facility_send_to_registration')
        ->first();

        if($registration){
            return view('licencing.pending.ppmv-registration-show', compact('registration'));
        }else{
            return abort(404);
        }
    }


    public function ppmvApprove(Request $request){

        try {
            DB::beginTransaction();

                $registration = Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
                ->where('status', 'facility_send_to_registration')
                ->first();

                if($registration){
                    Registration::where(['payment' => true, 'id' => $request['registration_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
                    ->where('status', 'facility_send_to_registration')
                    ->update([
                        'status' => 'licence_issued'
                    ]);

                    $PpmvLocationApplication = PpmvLocationApplication::where(['registration_id' => $registration->id, 'user_id' => $registration->user_id])
                    ->with('user')
                    ->latest()->first();

                    $renewal = Renewal::create([
                        'user_id' => $registration->user_id,
                        'registration_id' => $registration->id,
                        'form_id' => $PpmvLocationApplication->id,
                        'type' => 'ppmv_renewal',
                        'renewal_year' => date('Y'),
                        'expires_at' => \Carbon\Carbon::now()->format('Y') .'-12-31',
                        'licence' => 'TEST2021',
                        'status' => 'licence_issued',
                        'renewal' => false,
                        'inspection' => true,
                        'payment' => true,
                    ]);


                    $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
                    $activity = 'Registration & Licencing Issued Licence';
                    AllActivity::storeActivity($request['registration_id'], $adminName, $activity, 'ppmv');

                    $data = [
                        'user' => $registration->user,
                        'registration_type' => 'ppmv',
                        'type' => 'licencing_issued',
                    ];
                    EmailSendJOB::dispatch($data);

                }else{
                    return abort(404);
                }

        DB::commit();
            return redirect()->route('licence-pending.index')->with('success', 'Licence issued successfully done');
        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }
    }
}
