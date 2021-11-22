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
            'state'
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
                // dd($app['application']['user']['firstname']);

                if($app->activity == 'renewal_inspection'){
                    // $fields = [
                    //     'S/N' => $key+1, 
                    //     'Applicant name' => $app['user']['firstname'] .' '.$app['user']['lastname'],
                    //     'Year' => $app['registration_year'], 
                    //     'Type' =>  config('custom.status-category.category')[$app['type']],
                    //     'Category' => $app['category'],
                    //     'Status' => config('custom.status-category.status')[$app['status']], 
                    // ];
                    // array_push($array, $fields);
                }else{
                    $fields = [
                        'S/N' => $key+1, 
                        'Applicant name' => $app['application']['user']['firstname'] .' '.$app['application']['user']['lastname'],
                        'Year' => $app['application']['registration_year'], 
                        'Activity' =>  config('custom.report-activities.activities')[$app['activity']],
                        'Category' => config('custom.report-activities.category')[$app['application_type']],
                        'Status' => $app['status'] == 'pending' ? 'Pending' : 'Approved', 
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
