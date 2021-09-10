@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Tiered PPMV - Result', 'route' => 'meptp-application-result-show'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div id="invoiceWrapper">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="font-weight-bold">RESULT</h4>
                    <h2>
                        @if($application->result->status == 'pass')
                        <span class="badge badge-pill badge-success p-2 m-1">PASS</span> 
                        @elseif($application->result->status == 'fail')
                        <span class="badge badge-pill badge-danger p-2 m-1">FAIL</span> 
                        @endif
                    </h2>
                </div>
                <div class="col-md-6 text-sm-right">

                    <p><strong>Date: </strong>{{$application->result->created_at->format('d M')}} , {{$application->result->created_at->format('Y')}}</p>
                </div>
            </div>
            <div class="mt-3 mb-4 border-top"></div>
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-hover mb-4">
                        <thead class="bg-gray-300">
                            <tr>

                                <th scope="col">Batch</th>
                                <th scope="col">Tier</th>
                                <th scope="col">Centre</th>
                                <th scope="col">Index Number</th>
                                <th scope="col">Score</th>
                                <th scope="col">Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                {{$application->batch->batch_no}}/{{$application->batch->year}}/
                                </td>
                                <td>
                                {{$application->tier->name}}
                                </td>
                                <td>
                                {{$application->school->name}}
                                </td>
                                <td>
                                {{$application->indexNumber->arbitrary_1 .'/'. $application->indexNumber->arbitrary_2 .'/'. $application->indexNumber->batch_year .'/'. $application->indexNumber->state_code .'/'. $application->indexNumber->school_code .'/'. $application->indexNumber->tier .'/'. $application->indexNumber->id}}
                                </td>
                                <td>
                                {{$application->result->score}}
                                </td>
                                <td>
                                {{$application->result->percentage}}%
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection