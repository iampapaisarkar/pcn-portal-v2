@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['breads' => $breads])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <!-- <a href="{{route('services-fee.create', 'service=' . $service->id)}}"><button class="btn btn-primary" type="button">ADD FEE</button></a> -->
                <!-- <hr> -->
                @if(!$service->fees->isEmpty())
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Description</th>
                                @if(Request::get('service') == 15)
                                <th>Registration Fee</th>
                                <th>Inspection Fee</th>
                                @elseif(Request::get('service') == 16)
                                <th>Registration Fee</th>
                                <th>Inspection Fee</th>
                                <th>Renewal Fee</th>
                                <th>Location Fee</th>
                                @elseif(Request::get('service') == 17)
                                <th>Registration Fee</th>
                                <th>Inspection Fee</th>
                                <th>Renewal Fee</th>
                                <th>Location Fee</th>
                                @else
                                <th>Amount</th>
                                @endif
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @if(Request::get('service') == 15)
                                @foreach($service->fees as $fee)
                                <tr>
                                    <td>{{$fee->description}}</td>
                                    <td>N{{number_format($fee->registration_fee)}}</td>
                                    <td>N{{number_format($fee->inspection_fee)}}</td>
                                    <td><p><span
                                    class="badge badge-pill m-1 {{ $fee->status ? 'badge-success' : 'badge-warning' }}">
                                    {{ $fee->status ? 'ACTIVE' : 'DISABLED' }}
                                    </span></p></td>
                                    <td><a href="{{route('services-fee.show', $fee->id)}}?service={{$service->id}}"><button class="btn btn-info" type="button">VIEW</button></a></td>
                                </tr>
                                @endforeach
                                @elseif(Request::get('service') == 16)
                                @foreach($service->fees as $fee)
                                <tr>
                                    <td>{{$fee->description}}</td>
                                    <td>N{{number_format($fee->registration_fee)}}</td>
                                    <td>N{{number_format($fee->inspection_fee)}}</td>
                                    <td>N{{number_format($fee->renewal_fee)}}</td>
                                    <td>N{{number_format($fee->location_fee)}}</td>
                                    <td><p><span
                                    class="badge badge-pill m-1 {{ $fee->status ? 'badge-success' : 'badge-warning' }}">
                                    {{ $fee->status ? 'ACTIVE' : 'DISABLED' }}
                                    </span></p></td>
                                    <td><a href="{{route('services-fee.show', $fee->id)}}?service={{$service->id}}"><button class="btn btn-info" type="button">VIEW</button></a></td>
                                </tr>
                                @endforeach
                                @elseif(Request::get('service') == 17)
                                @foreach($service->fees as $fee)
                                <tr>
                                    <td>{{$fee->description}}</td>
                                    <td>N{{number_format($fee->registration_fee)}}</td>
                                    <td>N{{number_format($fee->inspection_fee)}}</td>
                                    <td>N{{number_format($fee->renewal_fee)}}</td>
                                    <td>N{{number_format($fee->location_fee)}}</td>
                                    <td><p><span
                                    class="badge badge-pill m-1 {{ $fee->status ? 'badge-success' : 'badge-warning' }}">
                                    {{ $fee->status ? 'ACTIVE' : 'DISABLED' }}
                                    </span></p></td>
                                    <td><a href="{{route('services-fee.show', $fee->id)}}?service={{$service->id}}"><button class="btn btn-info" type="button">VIEW</button></a></td>
                                </tr>
                                @endforeach
                                @else
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
                                @endif
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