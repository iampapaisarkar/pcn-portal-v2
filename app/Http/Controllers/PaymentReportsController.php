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
use App\Exports\PaymentReportExport;

class PaymentReportsController extends Controller
{
    public function report(){
        return view('generate-payment-report');
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

        $reports = Report::where('type', 'payment')
        ->with(
            'payment.application.user.user_state',
            'payment.application.user.user_lga',
            'payment.application.other_registration.company.company_state',
            'payment.application.other_registration.company.company_lga',
            'payment.renewal.registration.user.user_state',
            'payment.renewal.registration.user.user_lga',
            'payment.renewal.registration.other_registration.company.company_state',
            'payment.renewal.registration.other_registration.company.company_lga',
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

        $reports = $reports->whereBetween('created_at', [$request->date_from.' 00:00:00', $request->date_to.' 23:59:59']);
        $reports = $reports->select('reports.*')
        ->get();

        // dd($reports);

        if(!$reports->isEmpty()){
            $array = array();
            foreach ($reports as $key => $app) {
                if($app->activity == 'renewal_inspection'){
                    $fields = [
                        'Date' => $app['created_at']->format('d M Y'), 
                        'State' => strtoupper($app['state']['name']),
                        'Category' => strtoupper(config('custom.report-activities.category')[$app['application_type']]),
                        'Activity' =>  config('custom.report-activities.activities')[$app['activity']],
                        'Year' => $app['payment']['renewal']['application']['registration_year'], 
                        'Status' => $app['status'] == 'pending' ? 'PENDING' : 'PAID', 
                        'Amount' => number_format($app['payment']['total_amount']) . '.00',
                    ];
                    array_push($array, $fields);
                }else{
                    $fields = [
                        'Date' => $app['created_at']->format('d M Y'), 
                        'State' => strtoupper($app['state']['name']),
                        'Category' => strtoupper(config('custom.report-activities.category')[$app['application_type']]),
                        'Activity' =>  config('custom.report-activities.activities')[$app['activity']],
                        'Year' => $app['payment']['application']['registration_year'], 
                        'Status' => $app['status'] == 'pending' ? 'PENDING' : 'PAID', 
                        'Amount' => number_format($app['payment']['total_amount']) . '.00',
                    ];
                    array_push($array, $fields);
                }
                
            }
    
            $results = new PaymentReportExport($array);
    
            return Excel::download($results, 'payments-reports.xlsx');
        }else{
            return back()->with('error','No data found!');
        }
    }
}
