@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Applications - Training Approval Pending', 'route' => 'meptp-approval-states'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <h4 class=" mb-6">MEPTP Applications - Training Approval Pending</h4>
        <div class="row">
            @foreach($schools as $school)
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card card-icon mb-4">
                    <a href="{{ route('meptp-approval-lists') }}?school_id={{$school->id}}">
                    <div class="card-body text-center"><i class="i-Diploma"></i>
                        <p class="text-muted mt-2 mb-2">{{$school->name}}</p>
                        <p class="text-primary text-20 line-height-1 m-0">{{$school->total_application}}</p>
                    </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection