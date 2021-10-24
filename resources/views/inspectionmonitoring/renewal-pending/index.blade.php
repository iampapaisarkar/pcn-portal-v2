@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Licence Renewal - Inspection List', 'route' => 'monitoring-inspection-renewal.index'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card text-left">
    <div class="card-body">
        <h4>Licence Renewal - Inspection Pending</h4>
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
                    <form method="GET" action="{{ route('monitoring-inspection-renewal.index') }}">
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
                        <th>Category</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Year</th>
                        <th>Token</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                    <tr>
                        <td>{{$document->created_at->format('d/m/Y')}}</td>
                        <td>{{$document->registration->category}}</td>
                        <td>{{$document->other_registration->company->name}}</td>

                        @if($document->registration->type == 'community_pharmacy')
                        <td>Community Pharmacy Renewal Approval Application</td>
                        @endif
                        @if($document->registration->type == 'distribution_premises')
                        <td>Distribution Premises Renewal Approval Application</td>
                        @endif
                        @if($document->registration->type == 'manufacturing_premises')
                        <td>Pharmaceutical Manufacturing Premises Renewal Approval Application</td>
                        @endif

                        <td>{{$document->renewal_year}}</td>
                        <td>{{$document->registration->token}}</td>
                        <td><span class="badge badge-pill m-1 badge-warning">Pending</span></td>
                        <td>
                            @if($document->registration->type == 'community_pharmacy')
                            <a href="{{ route('monitoring-inspection-renewal-community-show') }}?renewal_id={{$document->id}}&user_id={{$document->user->id}}">
                                <button class="btn btn-success btn-sm" type="button"><i class="nav-icon i-Pen-2"></i></button>
                            </a>
                            @endif
                            @if($document->registration->type == 'distribution_premises')
                            <a href="{{ route('monitoring-inspection-renewal-distribution-show') }}?renewal_id={{$document->id}}&user_id={{$document->user->id}}">
                                <button class="btn btn-success btn-sm" type="button"><i class="nav-icon i-Pen-2"></i></button>
                            </a>
                            @endif
                            @if($document->registration->type == 'manufacturing_premises')
                            <a href="{{ route('monitoring-inspection-renewal-manufacturing-show') }}?renewal_id={{$document->id}}&user_id={{$document->user->id}}">
                                <button class="btn btn-success btn-sm" type="button"><i class="nav-icon i-Pen-2"></i></button>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Year</th>
                        <th>Token</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            {{$documents->links('pagination')}}
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