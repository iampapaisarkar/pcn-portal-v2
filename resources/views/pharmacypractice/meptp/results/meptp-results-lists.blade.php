@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Applications - Results Upload', 'route' =>
'meptp-approved-batches'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <form id="generateIndexNumberForm" class="w-100" method="POST"
            action="{{ route('meptp-generate-index-number') }}" enctype="multipart/form-data">
            @csrf
            <div class="card text-left">
                <div class="card-body">
                    <h4>Qualified Candidates List for Results {{Request::get('status') == 'false' ? 'Upload' : 'Uploaded'}}</h4>
                    <div class="table-responsive">
                        <div class="row m-0">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_length" id="multicolumn_ordering_table_length">
                                    <label>Show
                                        <select onchange="setPerPage(this);" name="multicolumn_ordering_table_length"
                                            aria-controls="multicolumn_ordering_table"
                                            class="form-control form-control-sm">
                                            <option {{Request::get('per_page') ? 'selected' : ''}} hidden
                                                value="{{Request::get('per_page')}}">{{Request::get('per_page')}}</option>
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
                                    <form method="GET" action="{{ route('meptp-results-lists') }}">
                                        @csrf
                                        <label>Search:
                                            <input name="search" value="{{Request::get('search')}}" type="text"
                                                class="form-control form-control-sm" placeholder=""
                                                aria-controls="multicolumn_ordering_table">
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
                                    <th>Index#</th>
                                    <th>Vendor Name</th>
                                    <th>Shop Name</th>
                                    <th>Batch</th>
                                    <th>State</th>
                                    <th>Training Centre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $key => $application)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$application->indexNumber->arbitrary_1 .'/'. $application->indexNumber->arbitrary_2 .'/'. $application->indexNumber->batch_year .'/'. $application->indexNumber->state_code .'/'. $application->indexNumber->school_code .'/'. $application->indexNumber->tier .'/'. $application->indexNumber->id}}</td>
                                    <td>{{$application->user->firstname}} {{$application->user->lastname}}</td>
                                    <td>{{$application->shop_name}}</td>
                                    <td>{{$application->batch->batch_no}}/{{$application->batch->year}}</td>
                                    <td>{{$application->user_state->name}}</td>
                                    <td>{{$application->school->name}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Index#</th>
                                    <th>Vendor Name</th>
                                    <th>Shop Name</th>
                                    <th>Batch</th>
                                    <th>State</th>
                                    <th>Training Centre</th>
                                </tr>
                            </tfoot>
                        </table>
                        {{$applications->links('pagination')}}
                    </div>
                    @if(Request::get('status') == 'false')
                    <form id="generateIndexNumberForm" class="w-100" method="POST" action="{{ route('meptp-upload-results') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title mb-3">Upload MEPTP Examination Results</h4>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <p>Download the template and complete accordingly</p>
                                <a class="btn btn-primary btn-icon m-1" href="{{ route('meptp-donwload-result-template') }}?school_id={{$schoolID}}&batch_id={{$batchID}}">
                                    <span class="ul-btn__icon"><i class="i-File-Excel"></i></span>
                                    <span class="ul-btn__text">DOWNLOAD TEMPLATE</span>
                                </a>
                                <p>Download the template and complete accordingly</p>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3 input-group">
                                            <div class="custom-file">
                                                <input  accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="result" class="custom-file-input" id="inputGroupFile02" type="file" required />
                                                <label class="custom-file-label" for="inputGroupFile02"
                                                    aria-describedby="inputGroupFileAddon02" id="inputGroupFile02previewLabel">Choose file</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">UPLOAD RESULT TEMPLATE</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-6 col-md-12">
                            </div>
                        </div>
                    </div>
                    </form>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function setPerPage(sel) {
    var url_string = window.location.href
    var new_url = new URL(url_string);
    let queryParams = (new_url).searchParams;
    var url_page = new_url.searchParams.get("per_page");

    var page = sel.value;
    var mParams = "?";
    if (queryParams != '') {
        mParams += queryParams + '&';
    }
    if (url_page !== null) {
        nParams = location.protocol + '//' + location.host + location.pathname + "?" + queryParams;
        var href = new URL(nParams);
        href.searchParams.set('per_page', page);
        window.location.href = href;
    } else {
        mParams += 'per_page=' + page;
        var new_url = location.protocol + '//' + location.host + location.pathname + mParams;
        window.location.href = new_url;
    }
}


function generateIndexNumber(event) {
    event.preventDefault();

    $.confirm({
        title: 'GENERATE INDEX NUMBERS AND EXAMINATION CARDS',
        content: 'Are you sure want to generated index number & examination cards for seleted applications?',
        buttons: {
            ok: {
                text: "YES",
                btnClass: 'btn-primary',
                keys: ['enter'],
                action: function() {
                    document.getElementById('generateIndexNumberForm').submit();
                }
            },
            cancel: function() {
                console.log('the user clicked cancel');
            }
        }
    });

}

// Educational Certificate Photo on upload preview 
inputGroupFile02.onchange = evt => {
    const [file] = inputGroupFile02.files
    if (file) {
        $('#inputGroupFile02previewLabel').html(file.name);
    }
}
</script>
@endsection