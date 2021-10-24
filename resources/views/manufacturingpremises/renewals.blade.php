@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Renewals', 'route' => 'mp-renewals.index'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card text-left">
            <div class="card-body">
            @if(app('App\Http\Services\CommunityDistributionInfo')->canAccessRenewalPage()['response'])
                <h2 class=" mb-6">Renewals</h2>
                @if(app('App\Http\Services\CommunityDistributionInfo')->licenceRenewalYearCheck()['response'])
                <a href="{{route('mp-renewal-form')}}"><button class="btn btn-primary" type="button">RENEW LICENCE</button></a>
                @else
                    @if(isset(app('App\Http\Services\CommunityDistributionInfo')->licenceRenewalYearCheck()['renewal_date']))
                    <h5>You can renwal on {{app('App\Http\Services\CommunityDistributionInfo')->licenceRenewalYearCheck()['renewal_date']}}</h5>
                    @endif
                @endif
                <div class="custom-separator"></div>

                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Year</th>
                                <th>Company Name</th>
                                <th>State</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($renewals as $renewal)
                            <tr>
                                <td>{{$renewal->renewal_year}}</td>
                                <td>{{$renewal->other_registration->company->name}}</td>
                                <td>{{$renewal->other_registration->company->company_state->name}}</td>
                                <td>
                                @if($renewal->status == 'send_to_registry')
                                    <p><span class="rounded badge w-badge badge-warning">PENDING</span></p>
                                @endif
                                @if($renewal->status == 'send_to_inspection_monitoring')
                                    <p><span class="rounded badge w-badge badge-warning">PENDING</span></p>
                                @endif
                                @if($renewal->status == 'no_recommendation')
                                    <p><span class="rounded badge w-badge badge-danger">NOT RECOMMENDATION</span></p>
                                    <a target="_blank" href="{{route('location-inspection-report-download', $renewal->registration->id)}}" class="btn btn-sm btn-primary">Download Report</a>
                                @endif
                                @if($renewal->status == 'full_recommendation')
                                    <p><span class="rounded badge w-badge badge-success">FULL RECOMMENDATION</span></p>
                                    <a target="_blank" href="{{route('location-inspection-report-download', $renewal->registration->id)}}" class="btn btn-sm btn-primary">Download Report</a>
                                @endif
                                @if($renewal->status == 'send_to_registration')
                                    <p><span class="rounded badge w-badge badge-warning">PENDING</span></p>
                                @endif
                                @if($renewal->status == 'licence_issued')
                                    <p><span class="rounded badge w-badge badge-success">APPROVED</span></p>
                                @endif
                                </td>
                                <td>
                                @if($renewal->status == 'no_recommendation')
                                <a href="{{route('mp-renewal-form-edit', $renewal->id)}}"><button class="btn btn-info btn-icon btn-sm m-0" type="button">UPDATE APPLICATION</button></a>
                                @endif
                                @if($renewal->status == 'licence_issued')
                                <a target="_blank" href=""><button class="btn btn-info btn-icon btn-sm m-0" type="button"> <span class="ul-btn__icon"><i class="i-Gear-2"></i></span> <span class="ul-btn__text">LICENCE</span></button></a>
                                @endif
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            @else
            <div class="alert alert-card alert-{{app('App\Http\Services\CommunityDistributionInfo')->canAccessRenewalPage()['color']}}" role="alert">
                {{app('App\Http\Services\CommunityDistributionInfo')->canAccessRenewalPage()['message']}}
            </div>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection