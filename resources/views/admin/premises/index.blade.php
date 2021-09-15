@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Premises Management', 'route' => 'premises.index'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <h2 class=" mb-6">Premises Management</h2>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($premises as $premise)
                            <tr>
                                <td>{{$premise->role}}</td>
                                <td><a href="{{route('public-users.index', 'role=' . $premise->id)}}&code={{$premise->code}}"><button class="btn btn-info" type="button">MANAGE</button></a></td>
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