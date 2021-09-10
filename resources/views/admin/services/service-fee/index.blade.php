@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Service Fees', 'route' => 'schools.index'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <a href="{{route('services-fee.create', 'service=' . $service->id)}}"><button class="btn btn-primary" type="button">ADD FEE</button></a>
                <hr>
                @if(!$service->fees->isEmpty())
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($service->fees as $fee)
                                <tr>
                                    <td>{{$fee->description}}</td>
                                    <td>N{{number_format($fee->amount)}}</td>
                                    <td><p><span
                                    class="badge badge-pill m-1 {{ $fee->status ? 'badge-success' : 'badge-warning' }}">
                                    {{ $fee->status ? 'ACTIVE' : 'DISABLED' }}
                                    </span></p></td>
                                    <td><a href="{{route('services-fee.show', $fee->id)}}?service={{$service->id}}"><button class="btn btn-info" type="button">VIEW</button></a></td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <span>No results found!</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection