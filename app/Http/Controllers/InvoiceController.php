<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HospitalRegistration;

use App\Models\Service;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;

use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceController extends Controller
{
    public function index(Request $request){
        $authUser = Auth::user();

        $invoices = Payment::with('user', 'service');

        if($authUser->hasRole(['sadmin'])){
            
            if($request->page){
                $perPage = (integer) $request->page;
            }else{
                $perPage = 10;
            }
    
            if(!empty($request->search)){
                $search = $request->search;
                $invoices = $invoices->where(function($q) use ($search){
                    $q->where('order_id', 'like', '%' .$search. '%');
                    // $q->orWhere('code', 'like', '%' .$search. '%');
                });
            }
            $invoices = $invoices->latest()->paginate($perPage);

        }else if($authUser->hasRole(['hospital_pharmacy', 'community_pharmacy', 'distribution_premisis', 'manufacturing_premisis', 'ppmv'])){

            $invoices = $invoices->latest()->where('vendor_id', $authUser->id)->get();
        }

        
        return view('invoice.index', compact('invoices'));
    }

    public function show($id){
        $authUser = Auth::user();

        $invoice = Payment::with('user', 'service.netFees')->where('id', $id);


        if($authUser->hasRole(['sadmin'])){
            $invoice = $invoice->first();
        }
        if($authUser->hasRole(['hospital_pharmacy'])){
            $invoice = $invoice->where('vendor_id', $authUser->id)->first();
        }
        if($authUser->hasRole(['community_pharmacy'])){
            $invoice = $invoice->where('vendor_id', $authUser->id)->first();
        }
        if($authUser->hasRole(['distribution_premisis'])){
            $invoice = $invoice->where('vendor_id', $authUser->id)->first();
        }
        if($authUser->hasRole(['manufacturing_premisis'])){
            $invoice = $invoice->where('vendor_id', $authUser->id)->first();
        }
        if($authUser->hasRole(['ppmv'])){
            $invoice = $invoice->where('vendor_id', $authUser->id)->first();
        }

        // dd($invoice);

        return view('invoice.show', compact('invoice'));
    }

    public function downloadInvoice($id){
        $authUser = Auth::user();

        $data = Payment::with('user.user_state', 'user.user_lga', 'service.netFees')->where('id', $id);
        
        if($authUser->hasRole(['sadmin'])){
            $data = $data->first();
        }else if($authUser->hasRole(['hospital_pharmacy', 'community_pharmacy', 'distribution_premisis', 'manufacturing_premisis', 'ppmv'])){
            $data = $data->where('vendor_id', $authUser->id)->first();
        }

        if($data){

            $client = new Party([
                'name'          => 'Pharmacists Council of Nigeria',
                'custom_fields' => [
                    'Address'        => 'Plot 7/9 Industrial Layout, Idu, P.M.B. 415 Garki, Abuja, Nigeria',
                ],
            ]);

            $customer = new Party([
                'name'          => $data->user->firstname  .' '. $data->user->lastname,
                'custom_fields' => [
                    'State' => $data->user->user_state->name,
                    'LGA' => $data->user->user_lga->name,
                ],
            ]);

            if($data->service_type == 'hospital_pharmacy'){
                $title = 'Hospital Pharmacy Registration Fees';
            }

            $items = [
                (new InvoiceItem())->title($title)->pricePerUnit($data->amount)->units($data->service->netFees),
            ];

            $logoURL = env('APP_URL') . '/admin/dist-assets/images/logo.png';

            $invoice = Invoice::make('Invoice')
                ->setCustomData([
                    'status' => $data->status
                ])
                ->series($data->order_id)
                ->serialNumberFormat('{SERIES}')
                ->seller($client)
                ->buyer($customer)
                ->date($data->created_at)
                ->dateFormat('m/d/Y')
                ->currencySymbol('NGN')
                ->currencyCode('NGN')
                ->currencyThousandsSeparator(',')
                ->currencyDecimalPoint('.')
                ->filename($title. '-' .$client->name)
                ->addItems($items)
                ->logo($logoURL);
                // You can additionally save generated invoice to configured disk
                // ->save('public');

                // dd($invoice);

            $link = $invoice->url();
            // Then send email to party with link

            // And return invoice itself to browser or have a different view
            return $invoice->stream();
        }else{
            return abort(404);
        }


    }
}
