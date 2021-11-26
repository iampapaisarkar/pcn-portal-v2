@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Invoices', 'route' => 'invoices.index'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="d-sm-flex mb-5" data-view="print"><span class="m-auto"></span>
            <!-- <button type="button" onclick="printDiv('invoiceWrapper')" class="btn btn-primary mb-sm-0 mb-3 print-invoice">Print Invoice</button> -->
            <a target="_blank" href="{{route('download-invoice', $invoice->id )}}" class="btn btn-primary mb-sm-0 mb-3 print-invoice">Print Invoice</a>
        </div>
        <!-- -===== Print Area =======-->
        <div id="invoiceWrapper">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="font-weight-bold">INVOICE DETAILS</h4>
                    <p>#{{$invoice->order_id}}</p>
                    <h2>
                        @if($invoice->status == true)
                        <span class="badge badge-pill badge-success p-2 m-1">PAID</span> 
                        @else
                        <span class="badge badge-pill badge-danger p-2 m-1">UNPAID</span> 
                        @endif
                        <!-- <span class="badge badge-pill badge-warning p-2 m-1">PENDING</span> -->
                    </h2>
                </div>
                <div class="col-md-6 text-sm-right">

                    <p><strong>Date: </strong>{{$invoice->created_at->format('d M')}} , {{$invoice->created_at->format('Y')}}</p>
                </div>
            </div>
            <div class="mt-3 mb-4 border-top"></div>
            <div class="row mb-5">
                <div class="col-md-6 mb-3 mb-sm-0">
                    <h5 class="font-weight-bold">Bill From</h5>
                    <p>Pharmacists Council of Nigeria</p>
                    <span style="white-space: pre-line">
                        Plot 7/9 Industrial Layout, Idu, P.M.B. 415 Garki, Abuja, Nigeria
                    </span>
                </div>
                <div class="col-md-6 text-sm-right">
                    <h5 class="font-weight-bold">Bill To</h5>
                    <p>{{$invoice->user->firstname}}  {{$invoice->user->lastname}}</p><span style="white-space: pre-line">
                        {{$invoice->user->phone}}
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-hover mb-4">
                        <thead class="bg-gray-300">
                            <tr>

                                <th scope="col">Description</th>
                                <th scope="col">Services</th>
                                <th scope="col">Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                
                                <td>
                                APPLICATION FOR {{$invoice->service->description}} 
                                </td>

                                <td>
                                    @foreach($invoice->service->netFees as $fee)
                                    <div>{{$fee->description}}: N{{number_format($fee->amount)}}</div>
                                    @endforeach
                                    @if($invoice->service_type == 'hospital_pharmacy' && $invoice->extra_service_id != null)
                                        @php 
                                            $extraService = App\Models\ServiceFeeMeta::where('id', $invoice->extra_service_id)->first();
                                            $extra_service =  $extraService;
                                        @endphp
                                        <div>{{$extra_service->description}}: Registration Fee N{{number_format($extra_service->registration_fee)}} : Inspection Fee N{{number_format($extra_service->inspection_fee)}}</div>
                                    @endif
                                    @if($invoice->service_type == 'hospital_pharmacy_renewal' && $invoice->extra_service_id != null)
                                        @php 
                                            $extraService = App\Models\ServiceFeeMeta::where('id', $invoice->extra_service_id)->first();
                                            $extra_service =  $extraService;
                                        @endphp
                                        <div>{{$extra_service->description}}: Registration Fee N{{number_format($extra_service->registration_fee)}} : Inspection Fee N{{number_format($extra_service->inspection_fee)}}</div>
                                    @endif
                                    @if($invoice->service_type == 'manufacturing_premises' && $invoice->extra_service_id != null)
                                        @php 
                                            $extraService = App\Models\ServiceFeeMeta::where('id', $invoice->extra_service_id)->first();
                                            $extra_service =  $extraService;
                                        @endphp
                                        <div>{{$extra_service->description}}: Registration Fee N{{number_format($extra_service->registration_fee)}} : Inspection Fee N{{number_format($extra_service->inspection_fee)}}
                                        </div>
                                    @endif
                                    @if($invoice->service_type == 'manufacturing_premises_renewal' && $invoice->extra_service_id != null)
                                        @php 
                                            $extraService = App\Models\ServiceFeeMeta::where('id', $invoice->extra_service_id)->first();
                                            $extra_service =  $extraService;
                                        @endphp
                                        <div>{{$extra_service->description}}: Inspection Fee N{{number_format($extra_service->inspection_fee)}}
                                            Renewal Fee N{{number_format($extra_service->renewal_fee)}}</div>
                                    @endif
                                    @if($invoice->service_type == 'distribution_premises_registration' && $invoice->extra_service_id != null)
                                        @php 
                                            $extraService = App\Models\ServiceFeeMeta::where('id', $invoice->extra_service_id)->first();
                                            $extra_service =  $extraService;
                                        @endphp
                                        <div>{{$extra_service->description}}: Registration Fee N{{number_format($extra_service->registration_fee)}} : Inspection Fee N{{number_format($extra_service->inspection_fee)}}</div>
                                    @endif
                                    @if($invoice->service_type == 'distribution_premises' && $invoice->extra_service_id != null)
                                        @php 
                                            $extraService = App\Models\ServiceFeeMeta::where('id', $invoice->extra_service_id)->first();
                                            $extra_service =  $extraService;
                                        @endphp
                                        <div>{{$extra_service->description}}: Location Fee N{{number_format($extra_service->location_fee)}}</div>
                                    @endif
                                    @if($invoice->service_type == 'distribution_premises_renewal' && $invoice->extra_service_id != null)
                                        @php 
                                            $extraService = App\Models\ServiceFeeMeta::where('id', $invoice->extra_service_id)->first();
                                            $extra_service =  $extraService;
                                        @endphp
                                        <div>{{$extra_service->description}}: Renewal Fee N{{number_format($extra_service->renewal_fee)} : Inspection Fee N{{number_format($extra_service->inspection_fee)}}}</div>
                                    @endif
                                    @if($invoice->service_type == 'ppmv_registration')
                                            @foreach (config('custom.ppmv-registration-fees') as $key => $extraService)
                                                <div>{{$extraService['description']}}: N{{number_format($extraService['fee'])}}</div>
                                            @endforeach
                                    @endif
                                </td>


                                <td>{{number_format($invoice->amount)}}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <div class="invoice-summary">
                        <p>Sub total: <span>NGN {{number_format($invoice->amount)}}</span></p>
                        <!-- <p>Service charge: <span>NGN {{number_format($invoice->service_charge)}}</span></p> -->

                        <h5 class="font-weight-bold">Grand Total: <span>NGN {{number_format($invoice->amount)}}</span></h5>
                    </div>
                </div>

                <div class="col-md-12">
                    
                    @if($invoice->status == false)
                    <button type="button" onclick="makePayment()" class="btn btn-primary mb-sm-0 mb-3">PAY NOW</button>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@if(Auth::user()->hasRole(['hospital_pharmacy', 'community_pharmacy', 'distribution_premises', 'manufacturing_premises', 'ppmv']) && $invoice->status == false)
<script type="text/javascript" src="https://remitademo.net/payment/v1/remita-pay-inline.bundle.js"></script>
<script>
    function makePayment() {
        var paymentEngine = RmPaymentEngine.init({
            key: '<?php echo env('REMITA_KEY') ?>',
            customerId: '<?php echo $invoice->user->id ?>',
            firstName: '<?php echo $invoice->user->firstname ?>',
            lastName: '<?php echo $invoice->user->lastname ?>',
            email: '<?php echo $invoice->user->email ?>',
            amount: '<?php echo $invoice->amount ?>',
            narration: '<?php echo env('REMITA_NARRATION') ?>',
            onSuccess: function(response) {
                // console.log('callback Successful Response', response);
                var param = '?am=' + response.amount + '&ref=' + response.paymentReference;
                window.location.href = "{{ route('payment-success', $invoice->token) }}" + param;
            },
            onError: function(response) {
                // console.log('callback Error Response', response);
                var param = '?am=' + response.amount + '&ref=' + response.paymentReference;
                window.location.href = "{{ route('payment-failed', $invoice->token) }}" + param;
            },
            onClose: function(response) {
                // console.log('callback Close Response', response);
                setTimeout(function(){ 
                    window.location.href = "{{ route('payment-failed', $invoice->token) }}";
                }, 5000);
            }
        });
        paymentEngine.showPaymentWidget();
    }
</script>
@endif

<!-- <script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        console.log("html", originalContents)

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script> -->
@endsection