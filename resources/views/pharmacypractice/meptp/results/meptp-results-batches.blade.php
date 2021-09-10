@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Applications - Results', 'route' => 'meptp-results-batches'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <h4 class=" mb-6">MEPTP Applications - Results</h4>
        <div class="table-responsive">
            <table class="display table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Batch</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($batches as $batch)
                    <tr>
                        <td>{{$batch['batch_no']}}/{{$batch['year']}}</td>
                        <td><span class="badge badge-pill m-1 badge-{{$batch['result_uploaded'] ? 'success' : 'warning' }}">{{$batch['result_uploaded'] ? 'RESULT UPLOADED' : 'PENDING RESULTS UPLOAD'}}</span></td>
                        <td><a href="{{ route('meptp-results-states', $batch['id']) }}?status={{$batch['status']}}"><button class="btn btn-info" type="button">VIEW</button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection