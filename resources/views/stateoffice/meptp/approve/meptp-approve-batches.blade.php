@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Applications - Documents Review Approved', 'route' => 'meptp-pending-batches'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <h4 class=" mb-6">MEPTP Applications - Documents Review Approved</h4>
        <div class="table-responsive">
            <table class="display table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Batch</th>
                        <th>State</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($batches as $batch)
                    <tr>
                        <td>{{$batch->batch_no}}/{{$batch->year}}</td>
                        <td>{{Auth::user()->user_state->name}}</td>
                        <td><span class="badge badge-pill m-1 badge-success">APPROVED</span></td>
                        <td><a href="{{route('meptp-approve-centre', $batch->id)}}"><button class="btn btn-info" type="button">VIEW</button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection