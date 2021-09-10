@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Tiered PPMV Registration - Recommended for Licence', 'route' => 'ppmv-licence-pending-lists'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <form id="licenceIssueForm" class="w-100" method="POST" action="{{ route('issue-licences') }}" enctype="multipart/form-data">
    @csrf
    <div class="card text-left">
    <div class="card-body">
        <h4>Tiered PPMV Registration - Recommended for Licence</h4>
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
                    <form method="GET" action="{{ route('ppmv-licence-pending-lists') }}">
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
                        <th>
                            <label class="checkbox checkbox-success">
                                <input id="check_box_bulk_action_select_all"  type="checkbox"  /><span class="checkmark"></span>
                            </label>
                        </th>
                        <th>Tier</th>
                        <th>Vendor Name</th>
                        <th>Shop Name</th>
                        <th>Year</th>
                        <th>State</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($licences as $key => $licence)
                    <tr>    
                        <td>{{$key+1}}</td>
                        <td>
                            <label class="checkbox checkbox-success">
                                <input class="check_box_bulk_action" id="check_box_bulk_action-{{$licence->id}}" type="checkbox" name="check_box_bulk_action[{{$licence->id}}]" /><span class="checkmark"></span>
                            </label>
                        </td>
                        <td>{{$licence->meptp_application->tier->name}}</td>
                        <td>{{$licence->user->firstname}} {{$licence->user->lastname}}</td>
                        <td>{{$licence->meptp_application->shop_name}}</td>
                        <td>{{$licence->renewal_year}}</td>
                        <td>{{$licence->user->user_state->name}}</td>
                        <td>
                            @if($licence->status == 'recommended')
                            <span class="badge badge-success">RECOMMENDED</span>
                            @endif
                        </td>
                        <td>
                        <a href="{{ route('ppmv-licence-pending-show', $licence->id) }}">
                        <button class="btn btn-success btn-sm" type="button"><i class="nav-icon i-Pen-2"></i></button></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>
                            <label class="checkbox checkbox-success">
                                <input id="check_box_bulk_action_select_all" type="checkbox"  /><span class="checkmark"></span>
                            </label>
                        </th>
                        <th>Tier</th>
                        <th>Vendor Name</th>
                        <th>Shop Name</th>
                        <th>Year</th>
                        <th>State</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            {{$licences->links('pagination')}}
        </div>
        <button onclick="issueLicecne(event)" type="button" class="btn btn-primary mt-5">ISSUE LICENCE (SELECTED)</button>
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

    $(function(){
        $("#check_box_bulk_action_select_all").click(function () {
            $(".check_box_bulk_action").prop('checked', $(this).prop('checked'));
        });    
    });

    function issueLicecne(event){
        event.preventDefault();

        $.confirm({
            title: 'Licence Issue',
            content: 'Are you sure want to issue the licecne for the selected applications?',
            buttons: {   
                ok: {
                    text: "YES",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                        document.getElementById('licenceIssueForm').submit();
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