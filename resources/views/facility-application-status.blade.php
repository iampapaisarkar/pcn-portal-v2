@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Location Approval Status', 'route' => 'location-approval-status'])
    <div class="row">
        <div class="col-lg-12 col-md-12">
            @if(app('App\Http\Services\CommunityDistributionInfo')->facilityStatus()['success'] == true)
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="alert alert-card alert-{{app('App\Http\Services\CommunityDistributionInfo')->facilityStatus()['color']}}" role="alert">
                            REGISTRATION STATUS:  {{app('App\Http\Services\CommunityDistributionInfo')->facilityStatus()['message']}}
                            @if(isset(app('App\Http\Services\CommunityDistributionInfo')->facilityStatus()['reason']))
                            <br>
                            <br>
                            <div>
                                <strong class="text-danger">REASON:</strong>
                                <br>
                                <p>{{app('App\Http\Services\CommunityDistributionInfo')->facilityStatus()['reason']}}</p>
                            </div>
                            @endif

                            @if(isset(app('App\Http\Services\CommunityDistributionInfo')->facilityStatus()['download-licence']))
                            <br>
                            <br>
                            <a href="{{app('App\Http\Services\CommunityDistributionInfo')->facilityStatus()['download-licence']}}" class="btn btn-success text-white btn-rounded ">Downlaod Licence</a>
                            @endif

                            @if(isset(app('App\Http\Services\CommunityDistributionInfo')->facilityStatus()['link']))
                            <br>
                            <br>
                            <a href="{{app('App\Http\Services\CommunityDistributionInfo')->facilityStatus()['link']}}" class="btn btn-danger text-white btn-rounded ">Update & Re-submit Registration</a>
                            @endif

                            @if(isset(app('App\Http\Services\CommunityDistributionInfo')->facilityStatus()['new-link']))
                            <br>
                            <br>
                            <a href="{{app('App\Http\Services\CommunityDistributionInfo')->facilityStatus()['new-link']}}" class="btn btn-danger text-white btn-rounded ">Re-submit Registration</a>
                            @endif

                            @if(isset(app('App\Http\Services\CommunityDistributionInfo')->facilityStatus()['download-link']))
                            <br>
                            <br>
                            <a href="{{app('App\Http\Services\CommunityDistributionInfo')->facilityStatus()['download-link']}}" target="_blank" class="btn btn-{{app('App\Http\Services\CommunityDistributionInfo')->facilityStatus()['color']}} text-white btn-rounded ">Download Inspection Report</a>
                            @endif
                        </div>
                    </div>
                </div>

                <x-location-registration-show
                :registrationID="$registration->id" 
                :userID="$registration->user_id" 
                :type="$registration->type" />

                <div class="custom-separator"></div>
            </div>
            @else
                <small>no status found!</small>
            @endif
        </div>
    </div>
@endsection