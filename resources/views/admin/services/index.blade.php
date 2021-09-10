@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Services', 'route' => 'schools.index'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <h2 class=" mb-6">Services Fees Management</h2>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Last Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr>
                                <td>{{$service->description}}</td>
                                <td> <p><span class="rounded badge w-badge badge-success">
                                        Updated {{$service->updated_at->format('d-M-Y')}}
                                    </span></p></td>
                                <td><a href="{{route('services-fee.index', 'service=' . $service->id)}}"><button class="btn btn-info" type="button">MANAGE</button></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection