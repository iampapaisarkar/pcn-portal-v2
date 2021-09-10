@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Applications - Documents Training Approved', 'route' => 'meptp-traning-approved-batches'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <h4 class=" mb-6">MEPTP Applications - Documents Training Approved</h4>
        <div class="table-responsive">
            <table class="display table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Batch</th>
                        <th>State</th>
                        <th>Index Number</th>
                        <th>Results</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($batches as $batch)
                    <tr>
                        <td>{{$batch['batch_no']}}/{{$batch['year']}}</td>
                        <td>{{Auth::user()->user_state->name}}</td>
                        <td><span class="badge badge-pill m-1 badge-{{$batch['index_status'] == 'true' ? 'success' : 'warning' }}">{{$batch['index_status'] == 'true' ? 'INDEX NUMBERS GENERATED' : 'INDEX NUMBERS PENDING'}}</span></td>
                        <td><span class="badge badge-pill m-1 badge-{{$batch['result_status'] == 'true' ? 'success' : 'warning' }}">{{$batch['result_status'] == 'true' ? 'RESULTS UPLOADED' : 'RESULTS UPLOAD PENDING'}}</span></td>
                        <td><a href="{{route('meptp-traning-approved-centre')}}?index={{$batch['index_status']}}&result={{$batch['result_status']}}&batch_id={{$batch['id']}}"><button class="btn btn-info" type="button">VIEW</button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection