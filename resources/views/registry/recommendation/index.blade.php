@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Facility Inspection Report', 'route' => 'registry-recommendation.index'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <form id="approvedForm" class="w-100" method="POST" action="{{ route('registry-approve-recommendation-all') }}" enctype="multipart/form-data">
    @csrf
    <div class="card text-left">
    <div class="card-body">
        <h4>Facility Inspection Report - Inspection Recommendation</h4>
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
                    <form method="GET" action="{{ route('registry-recommendation.index') }}">
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
                        <th>#</th>
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
                        <td>
                            <label class="checkbox checkbox-success">
                                <input class="check_box_bulk_action" id="check_box_bulk_action-{{$document->id}}" type="checkbox" name="check_box_bulk_action[{{$document->id}}]" /><span class="checkmark"></span>
                            </label>
                        </td>
                        <td>{{$document->category}}</td>

                        @if($document->type == 'hospital_pharmacy')
                        <td>{{$document->user->hospital_name}}</td>
                        @endif
                        @if($document->type == 'ppmv')
                        <td>{{$document->user->shop_name}}</td>
                        @endif
                        @if($document->type == 'community_pharmacy')
                        <td>{{$document->other_registration->company->name}}</td>
                        @endif
                        @if($document->type == 'distribution_premises')
                        <td>{{$document->other_registration->company->name}}</td>
                        @endif

                        @if($document->type == 'hospital_pharmacy')
                        <td>Hospital Pharmacy Registration</td>
                        @endif
                        @if($document->type == 'ppmv')
                        <td>PPMV Location Approval Application</td>
                        @endif
                        @if($document->type == 'community_pharmacy')
                        <td>Community Pharmacy Location Approval Application</td>
                        @endif
                        @if($document->type == 'distribution_premises')
                        <td>Distribution Premises Location Approval Application</td>
                        @endif

                        <td>{{$document->registration_year}}</td>
                        <td><span class="badge badge-pill m-1 badge-success">RECOMMENDED</span></td>
                        <td>
                            @if($document->type == 'hospital_pharmacy')
                            <a href="{{ route('registry-recommendation-show') }}?registration_id={{$document->id}}&user_id={{$document->user->id}}">
                                <button class="btn btn-success btn-sm" type="button"><i class="nav-icon i-Pen-2"></i></button>
                            </a>
                            @endif
                            @if($document->type == 'ppmv')
                            <a href="{{ route('registry-recommendation-ppmv-show') }}?registration_id={{$document->id}}&user_id={{$document->user->id}}">
                                <button class="btn btn-success btn-sm" type="button"><i class="nav-icon i-Pen-2"></i></button>
                            </a>
                            @endif
                            @if($document->type == 'community_pharmacy')
                            <a href="{{ route('registry-recommendation-community-show') }}?registration_id={{$document->id}}&user_id={{$document->user->id}}">
                                <button class="btn btn-success btn-sm" type="button"><i class="nav-icon i-Pen-2"></i></button>
                            </a>
                            @endif
                            @if($document->type == 'distribution_premises')
                            <a href="{{ route('registry-recommendation-distribution-show') }}?registration_id={{$document->id}}&user_id={{$document->user->id}}">
                                <button class="btn btn-success btn-sm" type="button"><i class="nav-icon i-Pen-2"></i></button>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
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
        <button onclick="approveSelected(event)" type="button" class="btn btn-primary mt-5">APPROVE SELETECD FOR FACILITY INSPECTION</button>
    </div>
</div>
</form>
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

    function approveSelected(event){
        event.preventDefault();

        $.confirm({
            title: 'APPROVE SELETECD FOR FACILITY INSPECTION',
            content: 'Are you sure want to approve for seleted registration?',
            buttons: {   
                ok: {
                    text: "YES",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                        document.getElementById('approvedForm').submit();
                    }
                },
                cancel: function(){
                        console.log('the user clicked cancel');
                }
            }
        });

    }
    </script>
@endsection