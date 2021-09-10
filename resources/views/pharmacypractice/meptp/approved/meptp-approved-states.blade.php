@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Application - Training Documents Approved', 'route' => 'meptp-approved-batches'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <h4 class=" mb-6">MEPTP Application - Training Documents Approved</h4>
        <div class="row">
            @foreach($states as $state)
            <div class="col-lg-2 col-md-2 col-sm-2">
                <div class="card card-icon mb-4">
                    <a href="{{ route('meptp-approved-centre', $state->id) }}?batch_id={{$batchID}}&status={{Request::get('status')}}">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">{{$state->name}}</p>
                        <p class="text-primary text-20 line-height-1 m-0">{{$state->total_application}}</p>
                    </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection