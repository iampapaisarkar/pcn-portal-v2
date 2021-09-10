<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MEPTPApplication;
use App\Models\PPMVApplication;
use App\Models\PPMVRenewal;

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
        }
        if(Auth::user()->hasRole(['state_office'])){
            $totalPendingMEPTP = MEPTPApplication::where(['state' => Auth::user()->state])->where('status', 'send_to_state_office')->count();
            $totalApprovedMEPTP = MEPTPApplication::where(['state' => Auth::user()->state])->where('status', 'send_to_pharmacy_practice')->count();

            $totalPendingPPMV = PPMVRenewal::whereHas('user', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->where('status', 'send_to_state_office')->count();

            $totalApprovedPPMV = PPMVRenewal::whereHas('user', function($q){
                $q->where('state', Auth::user()->state);
            })
            ->where('status', 'approved')->count();

            $data = [
                'meptp_pending' => [
                    'status' => 'Document Verification Pending',
                    'type' => 'METPT',
                    'total' => $totalPendingMEPTP
                ],
                'meptp_approved' => [
                    'status' => 'Document Verification Approved',
                    'type' => 'METPT',
                    'total' => $totalApprovedMEPTP
                ],
                'ppmv_pending' => [
                    'status' => 'Document Verification Approved',
                    'type' => 'Tiered PPMV Registration',
                    'total' => $totalPendingPPMV
                ],
                'ppmv_approved' => [
                    'status' => 'Document Verification Approved',
                    'type' => 'Tiered PPMV Registration',
                    'total' => $totalApprovedPPMV
                ]
            ];
                
        }
        if(Auth::user()->hasRole(['pharmacy_practice'])){
            $data= [];
        }
        if(Auth::user()->hasRole(['registration_licencing'])){
            $totalPendingPPMV = PPMVRenewal::where('status', 'recommended')->count();

            $totalApprovedPPMV = PPMVRenewal::where('status', 'licence_issued')->count();

            $data = [
                'ppmv_pending' => [
                    'status' => 'Licence Pending',
                    'type' => 'Tiered PPMV Registration',
                    'total' => $totalPendingPPMV
                ],
                'ppmv_approved' => [
                    'status' => 'Licence Approved',
                    'type' => 'Tiered PPMV Registration',
                    'total' => $totalApprovedPPMV
                ]
            ];
        }
        if(Auth::user()->hasRole(['vendor'])){
            $meptpApplication = MEPTPApplication::where(['vendor_id' => Auth::user()->id])->latest()->first();

            if($meptpApplication){
                if($meptpApplication->status == 'send_to_state_office'){
                    $data = [
                        'status' => 'PENDING',
                        'type' => 'METPT'
                    ];
                }
                if($meptpApplication->status == 'reject_by_state_office'){
                    $data = [
                        'status' => 'DOCS. QUERIED',
                        'type' => 'METPT'
                    ];
                }
                if($meptpApplication->status == 'send_to_pharmacy_practice'){
                    $data = [
                        'status' => 'PENDING',
                        'type' => 'METPT'
                    ];
                }
                if($meptpApplication->status == 'reject_by_pharmacy_practice'){
                    $data = [
                        'status' => 'DOCS. QUERIED',
                        'type' => 'METPT'
                    ];
                }
                if($meptpApplication->status == 'approved_tier_selected'){
                    $data = [
                        'status' => 'APPROVED',
                        'type' => 'METPT'
                    ];
                }
                if($meptpApplication->status == 'index_generated'){
                    $data = [
                        'status' => 'EXAM CARD',
                        'type' => 'METPT'
                    ];
                }
                if($meptpApplication->status == 'pass'){
                    $data = [
                        'status' => 'PASSED',
                        'type' => 'METPT'
                    ];
                }
                if($meptpApplication->status == 'fail'){
                    $data = [
                        'status' => 'FAILED',
                        'type' => 'METPT'
                    ];
                }

                $ppmvRenewal = PPMVRenewal::where(['vendor_id' => Auth::user()->id, 'meptp_application_id' => $meptpApplication->id])->latest()->first();

                if($ppmvRenewal){
                    if($ppmvRenewal->status == 'send_to_state_office'){
                        $data = [
                            'status' => 'PENDING',
                            'type' => 'Tiered PPMV Registration'
                        ];
                    }
                    if($ppmvRenewal->status == 'rejected'){
                        $data = [
                            'status' => 'DOCS. QUERIED',
                            'type' => 'Tiered PPMV Registration'
                        ];
                    }
                    if($ppmvRenewal->status == 'approved'){
                        $data = [
                            'status' => 'APPROVED',
                            'type' => 'Tiered PPMV Registration'
                        ];
                    }
                    if($ppmvRenewal->status == 'recommended'){
                        $data = [
                            'status' => 'RECOMMENDED',
                            'type' => 'Tiered PPMV Registration'
                        ];
                    }
                    if($ppmvRenewal->status == 'unrecommended'){
                        $data = [
                            'status' => 'NOT RECOMMENDED',
                            'type' => 'Tiered PPMV Registration'
                        ];
                    }
                    if($ppmvRenewal->status == 'licence_issued'){
                        $data = [
                            'status' => 'LICECNE ISSUED',
                            'type' => 'Tiered PPMV Registration'
                        ];
                    }
                }
            }else{
                $data = [
                    'status' => 'NO DATA',
                    'type' => 'Date not found yet'
                ];
            }

        }
        return view('index', compact('data'));
    }
}
