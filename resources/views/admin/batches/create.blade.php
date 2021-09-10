@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Add New MEPTP Batch', 'route' => 'batches.create'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card-body">
        <div class="card-title mb-3">Add New MEPTP Batch</div>
        <form method="POST" action="{{ route('batches.store') }}" enctype="multipart/form-data" novalidate>
        @csrf
            <label for="picker1">Select the Batch Number and year</label>
            <div class="row">
                <div class="col-md-3 form-group mb-3">
                    <select required name="batch_no" class="form-control @error('batch_no') is-invalid @enderror">
                        <option selected value="">Select Batch Number</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    @error('batch_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-3 form-group mb-3">
                    <select required name="year" class="form-control @error('year') is-invalid @enderror">
                        <option selected value="">Select Year</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                    @error('year')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
               
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">CREATE BATCH</button>
                    <div><span>** log Created By and Create At</span></div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
@endsection