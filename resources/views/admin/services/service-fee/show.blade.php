@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Service Fee', 'route' => 'services-fee.create'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card-body">
        <div class="card-title mb-3">View Fees</div>
        <form method="POST" action="{{route('services-fee.update', $fee->id)}}?service={{$service->id}}" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label for="description1">Fee Description</label>
                    <input value="{{ $fee->description }}" name="description" class="form-control @error('description') is-invalid @enderror" id="description1" type="text" placeholder="Enter description" />
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="amount1">Amount</label>
                    <input min="10" max="1000000" type="number" value="{{ $fee->amount }}" name="amount" class="form-control @error('amount') is-invalid @enderror" id="amount1" type="text" placeholder="Enter amount" />
                    @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="">Status</label> <br>
                    <input name="status" {{$fee->status == true ? 'checked' : ''}} class="text-white" type="checkbox" data-toggle="toggle" data-on="ACTIVE" data-off="DISABLED" data-onstyle="success" data-offstyle="warning">
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<style>
    .toggle-on{
        color: white!important;
    }
    .toggle-off{
        color: white!important;
    }
</style>
@endsection