@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Applications - Documents Approved', 'route' => 'meptp-approved-batches'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <h4 class=" mb-6">MEPTP Applications - Documents Approved</h4>
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
                        <td><span class="badge badge-pill m-1 badge-{{$batch['index_number_generated'] ? 'success' : 'warning' }}">{{$batch['index_number_generated'] ? 'INDEX NUMBERS GENERATED' : 'INDEX NUMBERS PENDING'}}</span></td>
                        <td><a href="{{ route('meptp-approved-states', $batch['id']) }}?status={{$batch['status']}}"><button class="btn btn-info" type="button">VIEW</button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection