<?php

namespace App\Http\Controllers\StateOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\AllActivity;
use App\Jobs\EmailSendJOB;

class DocumentReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $documents = Registration::where(['payment' => true, 'status' => 'send_to_state_office'])
        ->with('hospital_pharmacy', 'other_registration.company', 'user')
        // ->where('status', 'send_to_state_office')
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->orWhereHas('other_registration.company', function($q){
            $q->where('state', Auth::user()->state);
        });

        dd($documents->latest()->paginate($perPage));
        
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
                'token' => md5(uniqid(rand(), true)),
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
        ->with('user')
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

            $data = [
                'user' => $registration->user,
                'registration_type' => 'hospital_pharmacy',
                'type' => 'state_office_query',
                'query' => $request['query'],
            ];
            EmailSendJOB::dispatch($data);

            return redirect()->route('state-office-documents.index')->with('success', 'Registration Queried successfully done');
        }else{
            return abort(404);
        }
    }

    public function ppmvApprovalShow(Request $request){

        $application = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
        ->with('ppmv', 'user')
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->where('status', 'send_to_state_office')
        ->first();

        if($application){
            return view('stateoffice.documents.ppmv-approval-show', compact('application'));
        }else{
            return abort(404);
        }
    }


    public function ppmvApprove(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
        ->where('status', 'send_to_state_office')
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
            ->where('status', 'send_to_state_office')
            ->update([
                'token' => md5(uniqid(rand(), true)),
                'status' => 'send_to_registry'
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'State Officer Document Verification Approval';
            AllActivity::storeActivity($request['application_id'], $adminName, $activity, 'ppmv');

            return redirect()->route('state-office-documents.index')->with('success', 'Registration Approved successfully done');
        }else{
            return abort(404);
        }
    }

    public function ppmvReject(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
        ->where('status', 'send_to_state_office')
        ->with('user')
        ->whereHas('user', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'ppmv'])
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
            AllActivity::storeActivity($request['application_id'], $adminName, $activity, 'ppmv');

            $data = [
                'user' => $registration->user,
                'registration_type' => 'ppmv',
                'type' => 'state_office_query',
                'query' => $request['query'],
            ];
            EmailSendJOB::dispatch($data);

            return redirect()->route('state-office-documents.index')->with('success', 'Registration Queried successfully done');
        }else{
            return abort(404);
        }
    }


    public function communityApprovalShow(Request $request){

        $application = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy'])
        ->with('other_registration.company', 'user')
        ->whereHas('other_registration.company', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->where('status', 'send_to_state_office')
        ->first();

        if($application){
            return view('stateoffice.documents.community-approval-show', compact('application'));
        }else{
            return abort(404);
        }
    }


    public function communityApprove(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy'])
        ->with('other_registration.company', 'user')
        ->whereHas('other_registration.company', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy'])
            ->where('status', 'send_to_state_office')
            ->update([
                'token' => md5(uniqid(rand(), true)),
                'status' => 'send_to_registry'
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'State Officer Document Verification Approval';
            AllActivity::storeActivity($request['application_id'], $adminName, $activity, 'community_pharmacy');

            return redirect()->route('state-office-documents.index')->with('success', 'Registration Approved successfully done');
        }else{
            return abort(404);
        }
    }

    public function communityReject(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy'])
        ->with('other_registration.company', 'user')
        ->whereHas('other_registration.company', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'community_pharmacy'])
            ->where('status', 'send_to_state_office')
            ->with('other_registration.company', 'user')
            ->whereHas('other_registration.company', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->update([
                'status' => 'queried_by_state_office',
                'query' => $request['query'],
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'State Officer Document Verification Query';
            AllActivity::storeActivity($request['application_id'], $adminName, $activity, 'community_pharmacy');

            $data = [
                'user' => $registration->user,
                'registration_type' => 'community_pharmacy',
                'type' => 'state_office_query',
                'query' => $request['query'],
            ];
            EmailSendJOB::dispatch($data);

            return redirect()->route('state-office-documents.index')->with('success', 'Registration Queried successfully done');
        }else{
            return abort(404);
        }
    }



    public function distributionApprovalShow(Request $request){

        $application = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises'])
        ->with('other_registration.company', 'user')
        ->whereHas('other_registration.company', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->where('status', 'send_to_state_office')
        ->first();

        if($application){
            return view('stateoffice.documents.distribution-approval-show', compact('application'));
        }else{
            return abort(404);
        }
    }


    public function distributionApprove(Request $request){
        $registration = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises'])
        ->with('other_registration.company', 'user')
        ->whereHas('other_registration.company', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises'])
            ->where('status', 'send_to_state_office')
            ->update([
                'token' => md5(uniqid(rand(), true)),
                'status' => 'send_to_registry'
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'State Officer Document Verification Approval';
            AllActivity::storeActivity($request['application_id'], $adminName, $activity, 'distribution_premises');

            return redirect()->route('state-office-documents.index')->with('success', 'Registration Approved successfully done');
        }else{
            return abort(404);
        }
    }

    public function distributionReject(Request $request){

        $registration = Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises'])
        ->with('other_registration.company', 'user')
        ->whereHas('other_registration.company', function($q){
            $q->where('state', Auth::user()->state);
        })
        ->first();

        if($registration){
            Registration::where(['payment' => true, 'id' => $request['application_id'], 'user_id' => $request['user_id'], 'type' => 'distribution_premises'])
            ->where('status', 'send_to_state_office')
            ->with('other_registration.company', 'user')
            ->whereHas('other_registration.company', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->update([
                'status' => 'queried_by_state_office',
                'query' => $request['query'],
            ]);

            $adminName = Auth::user()->firstname .' '. Auth::user()->lastname;
            $activity = 'State Officer Document Verification Query';
            AllActivity::storeActivity($request['application_id'], $adminName, $activity, 'distribution_premises');

            $data = [
                'user' => $registration->user,
                'registration_type' => 'distribution_premises',
                'type' => 'state_office_query',
                'query' => $request['query'],
            ];
            EmailSendJOB::dispatch($data);

            return redirect()->route('state-office-documents.index')->with('success', 'Registration Queried successfully done');
        }else{
            return abort(404);
        }
    }
}
