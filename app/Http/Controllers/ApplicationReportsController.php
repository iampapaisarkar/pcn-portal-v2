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
use App\Models\Report;
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
            // 'state' => [
            //     'required'
            // ],
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

        $reports = Report::where('type', 'application')
        ->with(
            'application.user.user_state',
            'application.user.user_lga',
            'application.other_registration.company.company_state',
            'application.other_registration.company.company_lga',
            'renewal.registration.user.user_state',
            'renewal.registration.user.user_lga',
            'renewal.registration.other_registration.company.company_state',
            'renewal.registration.other_registration.company.company_lga',
            'state',
            'approvedBy'
        );

        if($request->state != "all"){
            $reports = $reports->where('state_id', $request->state);
        }

        if($request->category != "all"){
            $reports = $reports->where('application_type', $request->category);
        }

        if($request->activity != "all"){
            $reports = $reports->where('activity', $request->activity);
        }

        if($request->status != "all"){
            $reports = $reports->where('status', $request->status);
        }

        $reports = $reports->whereBetween('created_at', [\Carbon\Carbon::parse($request->date_from), \Carbon\Carbon::parse($request->date_to)]);
        $reports = $reports->select('reports.*')
        ->get();

        // dd($reports);

        if(!$reports->isEmpty()){
            $array = array();
            foreach ($reports as $key => $app) {
                if($app->activity == 'renewal_inspection'){
                    if($app['application_type'] == 'hospital_pharamcy'){

                        $name = $app['renewal']['registration']['user']['hospital_name'];
                        $address = $app['renewal']['registration']['user']['hospital_address'];
                        $state = $app['renewal']['registration']['user']['user_state']['name'];
                        $lga = $app['renewal']['registration']['user']['user_lga']['name'];

                    }else if($app['application_type'] == 'ppmv'){

                        $name = $app['renewal']['registration']['user']['hospital_name'];
                        $address = $app['renewal']['registration']['user']['hospital_address'];
                        $state = $app['renewal']['registration']['user']['user_state']['name'];
                        $lga = $app['renewal']['registration']['user']['user_lga']['name'];

                    }else if($app['application_type'] == 'community_pharmacy' || $app['application_type'] == 'distribution_premises' || $app['application_type'] == 'manufacturing_premises'){

                        $name = $app['renewal']['registration']['other_registration']['company']['name'];
                        $address = $app['renewal']['registration']['other_registration']['company']['address'];
                        $state = $app['renewal']['registration']['other_registration']['company']['company_state']['name'];
                        $lga = $app['renewal']['registration']['other_registration']['company']['company_lga']['name'];

                    }

                    $fields = [
                        'Date' => $app['created_at']->format('d M Y'), 
                        'State' => strtoupper($state),
                        'Category' => strtoupper(config('custom.report-activities.category')[$app['application_type']]),
                        'Activity' =>  config('custom.report-activities.activities')[$app['activity']],
                        'Year' => $app['renewal']['registration']['registration_year'], 
                        'Status' => $app['status'] == 'pending' ? 'PENDING' : 'APPROVED', 
                        'Name' => $name,
                        'Address' => $address,
                        'LGA' => $lga,
                        'Approved By' => $app['approvedBy'] ? $app['approvedBy']['firstname'] .' '.$app['approvedBy']['lastname'] : null,
                        'Approved On' => $app['approvedBy'] ? $app['created_at']->format('d M Y') : null,
                    ];
                    array_push($array, $fields);
                }else{
                    if($app['application_type'] == 'hospital_pharamcy'){

                        $name = $app['application']['user']['hospital_name'];
                        $address = $app['application']['user']['hospital_address'];
                        $state = $app['application']['user']['user_state']['name'];
                        $lga = $app['application']['user']['user_lga']['name'];

                    }else if($app['application_type'] == 'ppmv'){

                        $name = $app['application']['user']['hospital_name'];
                        $address = $app['application']['user']['hospital_address'];
                        $state = $app['application']['user']['user_state']['name'];
                        $lga = $app['application']['user']['user_lga']['name'];

                    }else if($app['application_type'] == 'community_pharmacy' || $app['application_type'] == 'distribution_premises' || $app['application_type'] == 'manufacturing_premises'){

                        $name = $app['application']['other_registration']['company']['name'];
                        $address = $app['application']['other_registration']['company']['address'];
                        $state = $app['application']['other_registration']['company']['company_state']['name'];
                        $lga = $app['application']['other_registration']['company']['company_lga']['name'];

                    }

                    $fields = [
                        'Date' => $app['created_at']->format('d M Y'), 
                        'State' => strtoupper($state),
                        'Category' => strtoupper(config('custom.report-activities.category')[$app['application_type']]),
                        'Activity' =>  config('custom.report-activities.activities')[$app['activity']],
                        'Year' => $app['application']['registration_year'], 
                        'Status' => $app['status'] == 'pending' ? 'PENDING' : 'APPROVED', 
                        'Name' => $name,
                        'Address' => $address,
                        'LGA' => $lga,
                        'Approved By' => $app['approvedBy'] ? $app['approvedBy']['firstname'] .' '.$app['approvedBy']['lastname'] : null,
                        'Approved On' => $app['approvedBy'] ? $app['created_at']->format('d M Y') : null,
                    ];
                    array_push($array, $fields);
                }
                
            }
    
            $results = new ApplicationReportExport($array);
    
            return Excel::download($results, 'application-reports.xlsx');
        }else{
            return back()->with('error','No data found!');
        }

        
    }
}
