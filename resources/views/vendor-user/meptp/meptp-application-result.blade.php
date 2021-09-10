@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Application - Result', 'route' => 'meptp-application-result'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card-body">
        @if(app('App\Http\Services\BasicInformation')->MEPTPApplicationResult()['is_result'] == true)
            <h4>MEPTP Application Result - Vendor Details</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                    <div class="alert alert-card alert-{{app('App\Http\Services\BasicInformation')->MEPTPApplicationResult()['color']}}" role="alert">{{app('App\Http\Services\BasicInformation')->MEPTPApplicationResult()['message']}}
                        @if(isset(app('App\Http\Services\BasicInformation')->MEPTPApplicationResult()['download_link']))
                        <a target="_blank" href="{{app('App\Http\Services\BasicInformation')->MEPTPApplicationResult()['download_link']}}" class="btn btn-rounded btn-success ml-3">View Result</a>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
            <x-vendor-m-e-p-t-p-application 
            :applicationID="app('App\Http\Services\BasicInformation')->MEPTPApplicationResult()['application_id']" 
            :vendorID="app('App\Http\Services\BasicInformation')->MEPTPApplicationResult()['vendor_id']"
            />
        @else
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                <div class="alert alert-card alert-{{app('App\Http\Services\BasicInformation')->MEPTPApplicationResult()['color']}}" role="alert">{{app('App\Http\Services\BasicInformation')->MEPTPApplicationResult()['message']}}
                </div>
                </div>
            </div>
        </div>
        @endif
        </div>

    </div>
</div>
@endsection