@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Application - Status', 'route' => 'meptp-application-status'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card-body">
        @if(app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['is_status'] == true)
            <h4>MEPTP Application Status - Vendor Details</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-card alert-{{app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['color']}}" role="alert">
                        {{app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['message']}}
                        @if(isset(app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['caption']))
                        <p><strong>REASONS: </strong></p>
                        <p>{{app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['caption']}}</p>
                        @endif
                        @if(isset(app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['download_link']))
                        <a target="_blank" class="btn btn-primary" href="{{app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['download_link']}}">Download Examination Card</a>
                        @endif
                    </div>
                </div>
            </div>
            @if(isset(app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['edit']) && app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['edit'] == true)
            <a href="{{route('meptp-application-edit')}}" class="btn  btn-primary m-1" name="save">Update MEPTP Application</a>
            @endif
            <x-vendor-m-e-p-t-p-application 
            :applicationID="app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['application_id']" 
            :vendorID="app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['vendor_id']"
            />
        @else
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-card alert-{{app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['color']}}" role="alert">
                   {{app('App\Http\Services\BasicInformation')->MEPTPApplicationStatus()['message']}}
                </div>
            </div>
        </div>
        @endif
        </div>

    </div>
</div>
@endsection