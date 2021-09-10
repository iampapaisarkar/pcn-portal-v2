@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Invoices', 'route' => 'invoices.index'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card text-left">
    <div class="card-body">
        <h3>Invoices</h3>
        <hr>
        <div class="table-responsive">
            @if(Auth::user()->hasRole(['sadmin']))
            <div class="row m-0">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length" id="multicolumn_ordering_table_length">
                        <label>Show 
                            <select onchange="setPerPage(this);" name="multicolumn_ordering_table_length" aria-controls="multicolumn_ordering_table" class="form-control form-control-sm">
                                <option {{Request::get('page') ? 'selected' : ''}} hidden value="{{Request::get('page')}}">{{Request::get('page')}}</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                        </select> entries
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div id="multicolumn_ordering_table_filter" class="dataTables_filter float-right">
                    <form method="GET" action="{{ route('schools.index') }}">
                    @csrf
                        <label>Search:
                            <input name="search" value="{{Request::get('search')}}" type="text" class="form-control form-control-sm" placeholder="" aria-controls="multicolumn_ordering_table">
                        </label>
                    </form>
                    </div>
                </div>
            </div>
            @endif
            <!--  id="multicolumn_ordering_table" -->
            <table class="display table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Invoice #</th>
                        <th>Description</th>
                        @if(Auth::user()->hasRole(['sadmin']))
                        <th>Name</th>
                        @endif
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr>
                        <td>{{$invoice->created_at->format('d-M-Y')}}</td>
                        <td>#{{$invoice->order_id}}</td>
                        <td>{{$invoice->service->description}}</td>
                        @if(Auth::user()->hasRole(['sadmin']))
                        <td>{{$invoice->user->firstname}} {{$invoice->user->lastname}}</td>
                        @endif
                        <td>N{{number_format($invoice->amount)}}</td>
                        @if($invoice->status == true)
                        <td><span class="badge badge-success">Paid</span></td>
                        @else
                        <td><span class="badge badge-warning">Unpaid</span></td>
                        @endif
                        @if(Auth::user()->hasRole(['sadmin']))
                        <td><a href="{{route('payments.show', $invoice->id)}}"><button class="btn btn-info" type="button">VIEW</button></a></td>
                        @else
                        <td><a href="{{route('invoices.show', $invoice->id)}}"><button class="btn btn-info" type="button">VIEW</button></a></td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if(Auth::user()->hasRole(['sadmin']))
                {{$invoices->links('pagination')}}
            @endif
        </div>
    </div>
</div>
</div>
</div>
@endsection