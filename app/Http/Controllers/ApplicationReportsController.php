<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\ChildService;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\HospitalRegistration;
use App\Models\OtherRegistration;
use App\Models\Renewal;
use DB;
use Validator;
use Excel;
use App\Exports\ApplicationReportExport;

class ApplicationReportsController extends Controller
{
    public function report(){
        return view('generate-application-report');
    }


    public function generateReport(Request $request){

        $this->validate($request, [
            'state' => [
                'required'
            ],
            'category' => [
                'required'
            ],
            'activity' => [
                'required'
            ],
            'status' => [
                'required'
            ],
            'date_from' => [
                'required'
            ],
            'date_to' => [
                'required'
            ]
        ]);

        $applications = Registration::where(['registrations.payment' => true])
        ->with('renewal', 'hospital_pharmacy', 'ppmv', 'other_registration.company', 'other_registration.company.company_state', 'other_registration.company.company_lga', 'other_registration.company.business', 'user', 'user.user_state', 'user.user_lga')
        ->leftjoin('users', 'users.id', 'registrations.user_id')
        ->leftjoin('other_registrations', 'other_registrations.registration_id', 'registrations.id')
        ->leftjoin('companies', 'other_registrations.company_id', 'companies.id')
        ->where(function($q) use($request){
            $q->where('users.state', $request->state);
            $q->orWhere('companies.state', $request->state);
        });

        if($request->category != 'all'){
            $applications = $applications->where('registrations.type', $request->category);
        }

        if($request->activity != 'all'){
            if($request->status == 'document_review'){
                if($request->status != 'all'){
                    if($request->status == 'pending'){
                        $applications = $applications->whereIn('registrations.status', ['send_to_state_office', 'queried_by_state_office']);
                    }else if($request->status == 'approved'){
                        $applications = $applications->whereIn('registrations.status', ['send_to_registry']);
                    }
                }else{
                    $applications = $applications->whereIn('registrations.status', ['send_to_state_office', 'queried_by_state_office', 'send_to_registry']);
                }

            }else if($request->status == 'location_inspection'){

                if($request->status != 'all'){
                    if($request->status == 'pending'){
                        $applications = $applications->whereIn('registrations.status', [
                            'send_to_inspection_monitoring',
                            'no_recommendation',
                            'send_to_pharmacy_practice',
                            'send_to_state_office_inspection',
                        ]);
                    }else if($request->status == 'approved'){
                        $applications = $applications->whereIn('registrations.status', [
                            'full_recommendation',
                            'partial_recommendation',
                            'inspection_approved',
                            'send_to_registration'
                        ]);
                    }
                }else{
                    $applications = $applications->whereIn('registrations.status',[
                        'send_to_inspection_monitoring',
                        'no_recommendation',
                        'send_to_pharmacy_practice',
                        'send_to_state_office_inspection',
                        'full_recommendation',
                        'partial_recommendation',
                        'inspection_approved',
                        'send_to_registration'
                    ]);
                }

            }else if($request->status == 'location_approval_banner'){

                $applications = $applications->whereIn('registrations.banner_status', 'pending');
                if($request->status != 'all'){
                    if($request->status == 'pending'){
                        $applications = $applications->where('registrations.banner_status', 'pending');
                    }else if($request->status == 'approved'){
                        $applications = $applications->where('registrations.banner_status', 'paid');
                    }
                }else{
                    $applications = $applications->whereIn('registrations.banner_status',[
                        'pending',
                        'paid'
                    ]);
                }

            }else if($request->status == 'facility_inspection'){

                if($request->status != 'all'){
                    if($request->status == 'pending'){
                        $applications = $applications->whereIn('registrations.status', [
                            'send_to_inspection_monitoring_registration',
                            'facility_no_recommendation',
                            'send_to_state_office_registration',
                        ]);
                    }else if($request->status == 'approved'){
                        $applications = $applications->whereIn('registrations.status', [
                            'facility_full_recommendation',
                            'facility_inspection_approved',
                            'facility_send_to_registration'
                        ]);
                    }
                }else{
                    $applications = $applications->whereIn('registrations.status',[
                        'send_to_inspection_monitoring_registration',
                        'facility_no_recommendation',
                        'send_to_state_office_registration',
                        'facility_full_recommendation',
                        'facility_inspection_approved',
                        'facility_send_to_registration'
                    ]);
                }

            }else if($request->status == 'renewal_inspection'){

                if($request->status != 'all'){
                    if($request->status == 'pending'){
                        $applications = $applications->whereHas('renewal', function($q){
                            $q->whereIn('registrations.status', [
                                'send_to_state_office',
                                'send_to_inspection_monitoring',
                                'send_to_pharmacy_practice',
                                'send_to_state_office_inspection',
                                'no_recommendation'
                            ]);
                        });
                    }else if($request->status == 'approved'){
                        $applications = $applications->whereHas('renewal', function($q){
                            $q->whereIn('registrations.status', [
                                'send_to_state_office',
                                'send_to_inspection_monitoring',
                                'send_to_pharmacy_practice',
                                'send_to_state_office_inspection',
                                'no_recommendation'
                            ]);
                        });
                    }
                }else{
                    $applications = $applications->whereHas('renewal', function($q){
                        $q->whereIn('registrations.status', [
                            'send_to_state_office',
                            'send_to_inspection_monitoring',
                            'send_to_pharmacy_practice',
                            'send_to_state_office_inspection',
                            'no_recommendation'
                        ]);
                    });
                }

            }
        }
        
        $applications = $applications->whereBetween('registrations.created_at', [\Carbon\Carbon::parse($request->date_from), \Carbon\Carbon::parse($request->date_to)]);
        $applications = $applications->select('registrations.*')
        ->latest()
        ->get();

        $array = array();
        foreach ($applications as $key => $app) {
            $fields = [
                'S/N' => $key+1, 
                'Applicant name' => $app['user']['firstname'] .' '.$app['user']['lastname'],
                'Year' => $app['registration_year'], 
                'Type' =>  config('custom.status-category.category')[$app['type']],
                'Category' => $app['category'],
                'Status' => config('custom.status-category.status')[$app['status']], 
            ];
            array_push($array, $fields);
        }

        $results = new ApplicationReportExport($array);

        return Excel::download($results, 'application-reports.xlsx');
    }
}
