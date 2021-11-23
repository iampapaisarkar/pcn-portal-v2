@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Location Approval Banner', 'route' => 'state-office-banner-paid.index'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card text-left">
    <div class="card-body">
        <h4>Location Approval Banner - Paid</h4>
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
                    <form method="GET" action="{{ route('state-office-banner-paid.index') }}">
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
                        <td>{{$document->category}}</td>

                        @if($document->type == 'ppmv')
                        <td>{{$document->user->shop_name}}</td>
                        @endif
                        @if($document->type == 'community_pharmacy')
                        <td>{{$document->other_registration->company->name}}</td>
                        @endif
                        @if($document->type == 'distribution_premises')
                        <td>{{$document->other_registration->company->name}}</td>
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

                        @if($document->payment == true)
                        <td><span class="badge badge-pill m-1 badge-success">Paid</span></td>
                        @else
                        <td><span class="badge badge-pill m-1 badge-warning">Pending</span></td>
                        @endif
                        <td>
                            <!-- <button data-toggle="modal" data-target="#verifyModalContent" class="btn btn-success btn-sm" type="button">COLLECTION</i></button> -->
                            <button onclick="showBannerModal({{$document}})" class="btn btn-success btn-sm" type="button">COLLECTION</i></button>
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

    <!--  Modal content -->
    <div class="modal fade" id="verifyModalContent" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{route('state-office-banner-collect')}}" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="verifyModalContent_title">LOCATION APPROVAL BANNER COLLECTION</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="registration_id" id="registrationId">
                <div class="form-row">
                <div class="col-lg-6 col-md-6">
                <label for="inputEmail3" class="ul-form__label"><strong>Category:</strong></label> <span id="category"></span>
                </div>
                <div class="col-lg-6 col-md-6">
                <label for="inputEmail3" class="ul-form__label"><strong>Date Approved:</strong></label> <span id="ApprovedDate"></span>
                </div>
                <div class="col-lg-6 col-md-6">
                <label for="inputEmail3" class="ul-form__label"><strong>Name:</strong></label> <span id="name"></span>
                </div>
                
                <div class="col-lg-6 col-md-6">
                <label for="inputEmail3" class="ul-form__label"><strong>Address:</strong></label> <span id="address"></span>
                </div>
                
                <div class="col-lg-6 col-md-6">
                <label for="inputEmail3" class="ul-form__label"><strong>State:</strong></label> <span id="state"></span>
                </div>
                
                <div class="col-lg-6 col-md-6">
                <label for="inputEmail3" class="ul-form__label"><strong>LGA:</strong></label> <span id="lga"></span>
                </div>
                
                </div>
                
                    <div class="form-group">
                        <label class="col-form-label" for="recipient-name-2">Recipient Name: *</label>
                        <input name="recipient_name" class="form-control" id="recipient-name-2" type="text" required />
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="message-text-1">Additional Comment: (optional)</label>
                        <textarea name="comment" class="form-control" id="message-text-1"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">CLOSE</button>
                <button class="btn btn-primary" type="submit">MARK AS COLLECTED</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--  End Modal content -->    
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

    function showBannerModal(data){
        if(data.type == 'community_pharmacy'){
            $('#registrationId').val(data.id);
            $('#category').text(data.category); 
            $('#ApprovedDate').text(moment(data.updated_at).format("DD MMM YYYY")); 
            $('#name').text(data.other_registration.company.name); 
            $('#address').text(data.other_registration.company.address); 
            $('#state').text(data.other_registration.company.company_state.name); 
            $('#lga').text(data.other_registration.company.company_lga.name); 
        }
        if(data.type == 'distribution_premises'){
            $('#registrationId').val(data.id); 
            $('#category').text(data.category); 
            $('#ApprovedDate').text(moment(data.updated_at).format("DDD MMM YYYY")); 
            $('#name').text(data.other_registration.company.name); 
            $('#address').text(data.other_registration.company.address); 
            $('#state').text(data.other_registration.company.company_state.name); 
            $('#lga').text(data.other_registration.company.company_lga.name); 
        }
        if(data.type == 'ppmv'){
            $('#registrationId').val(data.id); 
            $('#category').text(data.category); 
            $('#ApprovedDate').text(moment(data.updated_at).format("DDD MMM YYYY")); 
            $('#name').text(data.user.shop_name); 
            $('#address').text(data.user.shop_address); 
            $('#state').text(data.user.user_state.name); 
            $('#lga').text(data.user.user_lga.name); 
        }
        
        $('#verifyModalContent').modal('show'); 
    }
    </script>
@endsection