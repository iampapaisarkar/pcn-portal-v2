<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Registration;
use App\Models\Renewal;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data= [];
        if(Auth::user()->hasRole(['sadmin'])){
            $data= [];

            $adminUsers = User::join('user_roles', 'users.id', 'user_roles.user_id')
            ->join('roles', 'roles.id', 'user_roles.role_id')
            ->whereIn('code', ['state_office', 'registry', 'pharmacy_practice', 'inspection_monitoring', 'registration_licencing'])
            ->count();

            $vendorUsers = User::join('user_roles', 'users.id', 'user_roles.user_id')
            ->join('roles', 'roles.id', 'user_roles.role_id')
            ->whereIn('code', ['hospital_pharmacy', 'community_pharmacy', 'distribution_premises', 'manufacturing_premises', 'ppmv'])
            ->count();

            $data = [
                'admin_users' => $adminUsers,
                'vendor_users' => $vendorUsers,
            ];
        }
        if(Auth::user()->hasRole(['state_office'])){
            $pending_document = Registration::where(['payment' => true])
            ->whereHas('user', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->orWhereHas('other_registration.company', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->where('status', 'send_to_state_office')
            ->count();

            $approved_document = Registration::where(['payment' => true])
            ->whereHas('user', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->orWhereHas('other_registration.company', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->where('status', 'send_to_registry')
            ->count();

            $pending_inspection = Registration::where(['payment' => true])
            ->whereHas('user', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->orWhereHas('other_registration.company', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->where('status', 'send_to_state_office_inspection')
            ->where('location_approval', true)
            ->count();

            $report_inspection = Registration::where(['payment' => true])
            ->whereHas('user', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->orWhereHas('other_registration.company', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->where(function($q){
                $q->where('status', 'no_recommendation');
                $q->orWhere('status', 'partial_recommendation');
                $q->orWhere('status', 'full_recommendation');
            })
            ->where('location_approval', true)
            ->count();


            $pending_facility = Registration::where(['payment' => true])
            ->whereHas('user', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->orWhereHas('other_registration.company', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->where('status', 'send_to_state_office_registration')
            ->where('location_approval', false)
            ->count();

            $report_facility = Registration::where(['payment' => true])
            ->whereHas('user', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->orWhereHas('other_registration.company', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->where(function($q){
                $q->where('status', 'facility_no_recommendation');
                $q->orWhere('status', 'facility_full_recommendation');
            })
            ->where('location_approval', false)
            ->count();

            $data = [
                'pending_document' => $pending_document,
                'approved_document' => $approved_document,
                'pending_inspection' => $pending_inspection,
                'report_inspection' => $report_inspection,
                'pending_facility' => $pending_facility,
                'report_facility' => $report_facility,
            ];
                
        }
        if(Auth::user()->hasRole(['registry'])){
            $data= [];

            $location_inspection = Registration::where(['payment' => true])
            ->where('location_approval', true)
            ->where('status', 'send_to_registry')
            ->count();

            $location_report = Registration::where(['payment' => true])
            ->where(function($q){
                $q->where('status', 'full_recommendation');
            })
            ->where('location_approval', true)
            ->count();

            $facility_inspection = Registration::where(['payment' => true])
            ->where('status', 'send_to_registry')
            ->where('location_approval', false)
            ->count();

            $facility_report = Registration::where(['payment' => true])
            ->where(function($q){
                $q->where('status', 'full_recommendation');
            })
            ->where('location_approval', false)
            ->count();

            $renewal_inspection = Renewal::where(['payment' => true])
            ->where('status', 'send_to_registry')
            ->count();

            $renewal_report = Renewal::where(['payment' => true])
            ->where(function($q){
                $q->where('status', 'partial_recommendation');
                $q->orWhere('status', 'full_recommendation');
            })
            ->count();

            $data = [
                'location_inspection' => $location_inspection,
                'location_report' => $location_report,
                'facility_inspection' => $facility_inspection,
                'facility_report' => $facility_report,
                'renewal_inspection' => $renewal_inspection,
                'renewal_report' => $renewal_report,
            ];
        }
        if(Auth::user()->hasRole(['pharmacy_practice'])){
            $data= [];

            $facility_inspection = Registration::where(['payment' => true])
            ->where('status', 'send_to_pharmacy_practice')
            ->where('location_approval', false)
            ->count();

            $facility_report = Registration::where(['payment' => true])
            ->where(function($q){
                $q->where('status', 'no_recommendation');
                $q->orWhere('status', 'partial_recommendation');
                $q->orWhere('status', 'full_recommendation');
            })
            ->where('location_approval', false)
            ->count();

            $renewal_inspection = Renewal::where(['payment' => true])
            ->where('status', 'send_to_pharmacy_practice')
            ->count();

            $renewal_report = Renewal::where(['payment' => true])
            ->where(function($q){
                $q->where('status', 'no_recommendation');
                $q->orWhere('status', 'partial_recommendation');
                $q->orWhere('status', 'full_recommendation');
            })
            ->count();

            $data = [
                'facility_inspection' => $facility_inspection,
                'facility_report' => $facility_report,
                'renewal_inspection' => $renewal_inspection,
                'renewal_report' => $renewal_report,
            ];
        }
        if(Auth::user()->hasRole(['inspection_monitoring'])){
            $data= [];

            $location_inspection = Registration::where(['payment' => true])
            ->where('location_approval', true)
            ->where('status', 'send_to_inspection_monitoring')
            ->count();

            $location_report = Registration::where(['payment' => true])
            ->where(function($q){
                $q->where('status', 'no_recommendation');
            $q->orWhere('status', 'full_recommendation');
            })
            ->where('location_approval', true)
            ->count();

            $facility_inspection = Registration::where(['payment' => true])
            ->where('status', 'send_to_inspection_monitoring_registration')
            ->where('location_approval', false)
            ->count();

            $facility_report = Registration::where(['payment' => true])
            ->where(function($q){
                $q->where('status', 'no_recommendation');
            $q->orWhere('status', 'full_recommendation');
            })
            ->where('location_approval', false)
            ->count();

            $renewal_inspection = Renewal::where(['payment' => true])
            ->where('status', 'send_to_inspection_monitoring')
            ->count();

            $renewal_report = Renewal::where(['payment' => true])
            ->where(function($q){
                $q->where('status', 'no_recommendation');
                $q->orWhere('status', 'full_recommendation');
            })
            ->count();

            $data = [
                'location_inspection' => $location_inspection,
                'location_report' => $location_report,
                'facility_inspection' => $facility_inspection,
                'facility_report' => $facility_report,
                'renewal_inspection' => $renewal_inspection,
                'renewal_report' => $renewal_report,
            ];
        }
        if(Auth::user()->hasRole(['registration_licencing'])){
            $data= [];

            $licence_pending = Renewal::where(['payment' => true])
            ->where(function($q){
                $q->where('status', 'send_to_registration');
                $q->orWhere('status', 'facility_send_to_registration');
            })
            ->count();

            $licence_issued = Renewal::where(['payment' => true])
            ->where(function($q){
                $q->where('status', 'licence_issued');
            })
            ->count();

            $data = [
                'licence_pending' => $licence_pending,
                'licence_issued' => $licence_issued,
            ];
        }
        if(Auth::user()->hasRole(['hospital_pharmacy'])){
            $data= [];

            $registration = Registration::where(['payment' => true])
            ->where('type', 'hospital_pharmacy')
            ->latest()
            ->first();

            if($registration){
                if($registration->status == 'send_to_state_office'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'queried_by_state_office'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REVIEW QUERIED',
                    ];
                }
                if($registration->status == 'send_to_registry'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'send_to_pharmacy_practice'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'no_recommendation'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REVIEW NOT RECOMMENDED',
                    ];
                }
                if($registration->status == 'partial_recommendation'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REVIEW PARTIAL RECOMMENDED',
                    ];
                }
                if($registration->status == 'full_recommendation'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REVIEW FULL RECOMMENDED',
                    ];
                }
                if($registration->status == 'send_to_registration'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. APPROVED FOR LICENCING',
                    ];
                }
                if($registration->status == 'licence_issued'){
                    $data = [
                        'title' => 'REGISTRATION LICENCING',
                        'status' => 'LICENCE ISSUED',
                    ];
                }
            }else{
                $data = [
                    'title' => 'NO DATA FOUND',
                    'status' => '-',
                ];
            }
            
        }
        if(Auth::user()->hasRole(['community_pharmacy'])){
            $data= [];

            $registration = Registration::where(['payment' => true])
            ->where('type', 'community_pharmacy')
            ->latest()
            ->first();

            if($registration){
                if($registration->status == 'send_to_state_office'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'queried_by_state_office'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW QUERIED',
                    ];
                }
                if($registration->status == 'send_to_registry'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'send_to_inspection_monitoring'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'no_recommendation'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW NOT RECOMMENDED',
                    ];
                }
                if($registration->status == 'full_recommendation'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW FULL RECOMMENDED',
                    ];
                }
                if($registration->status == 'inspection_approved'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. APPROVED OFR REGISTRATION',
                    ];
                }
                if($registration->status == 'send_to_inspection_monitoring_registration'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'facility_no_recommendation'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REGISTRATION NOT RECOMMENDED',
                    ];
                }
                if($registration->status == 'facility_full_recommendation'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REGISTRATION FULL RECOMMENDED',
                    ];
                }
                if($registration->status == 'facility_inspection_approved'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. APPROVED FOR LICENCING',
                    ];
                }
                if($registration->status == 'licence_issued'){
                    $data = [
                        'title' => 'REGISTRATION LICENCING',
                        'status' => 'LICENCE ISSUED',
                    ];
                }
            }else{
                $data = [
                    'title' => 'NO DATA FOUND',
                    'status' => '-',
                ];
            }
        }
        if(Auth::user()->hasRole(['distribution_premises'])){
            $data= [];

            $registration = Registration::where(['payment' => true])
            ->where('type', 'distribution_premises')
            ->latest()
            ->first();

            if($registration){
                if($registration->status == 'send_to_state_office'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'queried_by_state_office'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW QUERIED',
                    ];
                }
                if($registration->status == 'send_to_registry'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'send_to_inspection_monitoring'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'no_recommendation'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW NOT RECOMMENDED',
                    ];
                }
                if($registration->status == 'full_recommendation'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW FULL RECOMMENDED',
                    ];
                }
                if($registration->status == 'inspection_approved'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. APPROVED OFR REGISTRATION',
                    ];
                }
                if($registration->status == 'send_to_inspection_monitoring_registration'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'facility_no_recommendation'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REGISTRATION NOT RECOMMENDED',
                    ];
                }
                if($registration->status == 'facility_full_recommendation'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REGISTRATION FULL RECOMMENDED',
                    ];
                }
                if($registration->status == 'facility_inspection_approved'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. APPROVED FOR LICENCING',
                    ];
                }
                if($registration->status == 'licence_issued'){
                    $data = [
                        'title' => 'REGISTRATION LICENCING',
                        'status' => 'LICENCE ISSUED',
                    ];
                }
            }else{
                $data = [
                    'title' => 'NO DATA FOUND',
                    'status' => '-',
                ];
            }
        }
        if(Auth::user()->hasRole(['manufacturing_premises'])){
            $data= [];

            $registration = Registration::where(['payment' => false])
            ->where('type', 'community_pharmacy')
            ->latest()
            ->first();

            if($registration){
                if($registration->status == 'send_to_registry'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'send_to_inspection_monitoring'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'facility_no_recommendation'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REGISTRATION NOT RECOMMENDED',
                    ];
                }
                if($registration->status == 'facility_full_recommendation'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REGISTRATION FULL RECOMMENDED',
                    ];
                }
                if($registration->status == 'facility_send_to_registration'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. APPROVED FOR LICENCING',
                    ];
                }
                if($registration->status == 'licence_issued'){
                    $data = [
                        'title' => 'REGISTRATION LICENCING',
                        'status' => 'LICENCE ISSUED',
                    ];
                }
            }else{
                $data = [
                    'title' => 'NO DATA FOUND',
                    'status' => '-',
                ];
            }
        }
        if(Auth::user()->hasRole(['ppmv'])){
            $data= [];

            $registration = Registration::where(['payment' => true])
            ->where('type', 'community_pharmacy')
            ->latest()
            ->first();

            if($registration){
                if($registration->status == 'send_to_state_office'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'queried_by_state_office'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW QUERIED',
                    ];
                }
                if($registration->status == 'send_to_registry'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'send_to_state_office_inspection'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'no_recommendation'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW NOT RECOMMENDED',
                    ];
                }
                if($registration->status == 'full_recommendation'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. REVIEW FULL RECOMMENDED',
                    ];
                }
                if($registration->status == 'inspection_approved'){
                    $data = [
                        'title' => 'LOCATION APPLICATION REVIEW',
                        'status' => 'DOC. APPROVED OFR REGISTRATION',
                    ];
                }
                if($registration->status == 'send_to_state_office_registration'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REVIEW PENDING',
                    ];
                }
                if($registration->status == 'facility_no_recommendation'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REGISTRATION NOT RECOMMENDED',
                    ];
                }
                if($registration->status == 'facility_full_recommendation'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. REGISTRATION FULL RECOMMENDED',
                    ];
                }
                if($registration->status == 'facility_inspection_approved'){
                    $data = [
                        'title' => 'REGISTRATION REVIEW',
                        'status' => 'DOC. APPROVED FOR LICENCING',
                    ];
                }
                if($registration->status == 'licence_issued'){
                    $data = [
                        'title' => 'REGISTRATION LICENCING',
                        'status' => 'LICENCE ISSUED',
                    ];
                }
            }else{
                $data = [
                    'title' => 'NO DATA FOUND',
                    'status' => '-',
                ];
            }
        }
        return view('index', compact('data'));
    }
}
