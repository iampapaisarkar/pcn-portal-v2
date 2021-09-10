@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Applications - Documents Review Approved', 'route' => 'meptp-approve-batches'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card text-left">
    <div class="card-body">
        <h4>MEPTP Applications - Documents Review Approved</h4>
        <div class="table-responsive">
            <div class="row m-0">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length" id="multicolumn_ordering_table_length">
                        <label>Show 
                            <select onchange="setPerPage(this);" name="multicolumn_ordering_table_length" aria-controls="multicolumn_ordering_table" class="form-control form-control-sm">
                                <option {{Request::get('per_page') ? 'selected' : ''}} hidden value="{{Request::get('per_page')}}">{{Request::get('per_page')}}</option>
                                <option selected hidden value="10">10</option>
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
                    <form method="GET" action="{{ route('meptp-approve-lists') }}">
                    @csrf
                        <label>Search:
                            <input name="search" value="{{Request::get('search')}}" type="text" class="form-control form-control-sm" placeholder="" aria-controls="multicolumn_ordering_table">
                        </label>
                    </form>
                    </div>
                </div>
            </div>
            <!--  id="multicolumn_ordering_table" -->
            <table class="display table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Vendor Name</th>
                        <th>Shop Name</th>
                        <th>Batch</th>
                        <th>State</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                    <tr>
                        <td>{{$application->created_at->format('d/m/Y')}}</td>
                        <td>{{$application->user->firstname}} {{$application->user->lastname}}</td>
                        <td>{{$application->shop_name}}</td>
                        <td>{{$application->batch->batch_no}}/{{$application->batch->year}}</td>
                        <td>{{$application->user_state->name}}</td>
                        <td><span class="badge badge-pill m-1 badge-success">Approved</span></td>
                        <td><a href="{{ route('meptp-approve-show') }}?application_id={{$application->id}}&batch_id={{$application->batch_id}}&school_id={{$application->traing_centre}}&vendor_id={{$application->user->id}}">
                            <button class="btn btn-success btn-sm" type="button"><i class="nav-icon i-Pen-2"></i></button></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Vendor Name</th>
                        <th>Shop Name</th>
                        <th>Batch</th>
                        <th>State</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            {{$applications->links('pagination')}}
        </div>
    </div>
</div>
</div>
</div>
    <script type="text/javascript">
    function setPerPage(sel){
        var url_string = window.location.href
        var new_url = new URL(url_string);
        let queryParams = (new_url).searchParams;
        var url_page = new_url.searchParams.get("per_page"); 

        var page = sel.value;
        var mParams = "?";
        if(queryParams != ''){
            mParams += queryParams+'&';
        }
        if ( url_page !== null){
            nParams = location.protocol + '//' + location.host + location.pathname + "?"+queryParams;
            var href = new URL(nParams);
            href.searchParams.set('per_page', page);
            window.location.href = href;
        }else{
            mParams += 'per_page='+page;
            var new_url = location.protocol + '//' + location.host + location.pathname + mParams;
            window.location.href = new_url;
        }
    }
    </script>
@endsection