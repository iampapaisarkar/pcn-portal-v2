@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Renewals', 'route' => 'ppmv-renewal'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card text-left">
            <div class="card-body">
            @if(app('App\Http\Services\BasicInformation')->canAccessRenewalPage()['response'])
                <h2 class=" mb-6">Renewals</h2>
                @if(app('App\Http\Services\BasicInformation')->licenceRenewalYearCheck()['response'])
                <a href="{{route('renew-licence')}}"><button class="btn btn-primary" type="button">RENEW LICENCE</button></a>
                @else
                    @if(isset(app('App\Http\Services\BasicInformation')->licenceRenewalYearCheck()['renewal_date']))
                    <h5>You can renwal on {{app('App\Http\Services\BasicInformation')->licenceRenewalYearCheck()['renewal_date']}}</h5>
                    @endif
                @endif
                <div class="custom-separator"></div>

                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Year</th>
                                <th>Vendor Name</th>
                                <th>Shop Name</th>
                                <th>State</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($renewals as $renewal)
                            <tr>
                                <td>{{$renewal->renewal_year}}</td>
                                <td>{{$renewal->user->firstname}} {{$renewal->user->lastname}}</td>
                                <td>{{$renewal->meptp_application->shop_name}}</td>
                                <td>{{$renewal->meptp_application->user_state->name}}</td>
                                
                                <td>
                                @if($renewal->status == 'pending')
                                    <p><span class="rounded badge w-badge badge-warning">PENDING</span></p>
                                @endif
                                @if($renewal->status == 'approved')
                                    <p><span class="rounded badge w-badge badge-warning">PENDING</span></p>
                                @endif
                                @if($renewal->status == 'rejected')
                                    <p><span class="rounded badge w-badge badge-warning">QUERIED</span></p>
                                @endif
                                @if($renewal->status == 'recommended')
                                    <p><span class="rounded badge w-badge badge-warning">PENDING</span></p>
                                @endif
                                @if($renewal->status == 'unrecommended')
                                    <p><span class="rounded badge w-badge badge-warning">NOT RECOMMENDED</span></p>
                                @endif
                                @if($renewal->status == 'licence_issued')
                                    <p><span class="rounded badge w-badge badge-success">APPROVED</span></p>
                                @endif
                                </td>


                                <td>
                                @if($renewal->status == 'rejected')
                                <a href="{{route('ppmv-application-edit', $renewal->ppmv_application_id)}}"><button class="btn btn-info btn-icon btn-sm m-0" type="button"> UPDATE APPLICATION</button></a>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#queryModal{{$renewal->id}}">
                                VIEW REASON
                                </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="queryModal{{$renewal->id}}" tabindex="-1" aria-labelledby="queryModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="queryModalLabel">Reason of Query</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        {{$renewal->query}}
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                @endif
                                @if($renewal->status == 'unrecommended')
                                <a href="{{route('ppmv-application-edit', $renewal->ppmv_application_id)}}"><button class="btn btn-info btn-icon btn-sm m-0" type="button"> UPDATE APPLICATION</button></a>
                                @endif
                                @if($renewal->status == 'licence_issued')
                                <a target="_blank" href="{{route('download-licence', $renewal->id)}}"><button class="btn btn-info btn-icon btn-sm m-0" type="button"> <span class="ul-btn__icon"><i class="i-Gear-2"></i></span> <span class="ul-btn__text">LICENCE</span></button></a>
                                @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
            <div class="alert alert-card alert-{{app('App\Http\Services\BasicInformation')->canAccessRenewalPage()['color']}}" role="alert">
                {{app('App\Http\Services\BasicInformation')->canAccessRenewalPage()['message']}}
            </div>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection