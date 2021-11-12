@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Facility Inspection Report', 'route' => 'pharmacy-renewal-reports.index'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card text-left">
    <div class="card-body">
        <h4>Facility Inspection Report</h4>
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
                    <form method="GET" action="{{ route('pharmacy-renewal-reports.index') }}">
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
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                    <tr>
                        <td>{{$document->created_at->format('d/m/Y')}}</td>
                        <td>{{$document->registration->category}}</td>

                        @if($document->registration->type == 'hospital_pharmacy')
                        <td>{{$document->user->hospital_name}}</td>
                        @endif
                        @if($document->registration->type == 'ppmv')
                        <td>{{$document->user->shop_name}}</td>
                        @endif
                        
                        @if($document->registration->type == 'hospital_pharmacy')
                        <td>Hospital Pharmacy Registration</td>
                        @endif
                        @if($document->registration->type == 'ppmv')
                        <td>PPMV Location Approval Application</td>
                        @endif

                        <td>{{$document->registration->registration_year}}</td>

                        @if($document->status == 'no_recommendation')
                        <td><span class="badge badge-pill m-1 badge-danger">NO RECOMMENDATION</span></td>
                        @endif
                        @if($document->status == 'partial_recommendation')
                        <td><span class="badge badge-pill m-1 badge-warning">PARTIAL RECOMMENDATION</span></td>
                        @endif
                        @if($document->status == 'full_recommendation')
                        <td><span class="badge badge-pill m-1 badge-success">FULL RECOMMENDATION</span></td>
                        @endif

                        <td>
                            @if($document->registration->type == 'hospital_pharmacy')
                            <a href="{{ route('pharmacy-renewal-reports-show') }}?renewal_id={{$document->id}}&user_id={{$document->user->id}}">
                                <button class="btn btn-success btn-sm" type="button"><i class="nav-icon i-Eye"></i></button>
                            </a>
                            @endif
                            <!-- @if($document->registration->type == 'ppmv')
                            <a href="{{ route('pharmacy-renewal-reports-ppmv-show') }}?renewal_id={{$document->id}}&user_id={{$document->user->id}}">
                                <button class="btn btn-success btn-sm" type="button"><i class="nav-icon i-Eye"></i></button>
                            </a>
                            @endif -->
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