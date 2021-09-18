@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Registration', 'route' => 'ppmv-facility-application-form'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card-body">
            <!--begin::form-->
            @if(app('App\Http\Services\PPMVApplicationInfo')->canSubmitPPMVFacilityApplication()['success'] == true)
            <form method="POST" action="{{ route('ppmv-facility-application-form-submit') }}" enctype="multipart/form-data" novalidate>
            @csrf
                <h4>PPMV Details</h4>
                <div class="row">
                    <div class="form-group col-md-6">
                        <img style="width: 25%;" src="{{Auth::user()->photo ? asset('images/' . Auth::user()->photo) : asset('admin/dist-assets/images/avatar.jpg') }}" alt="">
                    </div>
                    <div class="form-group col-md-6">
                        <h3>Year: {{date('Y')}}<h3>
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="firstName1">First name</label>
                        <input name="firstname" class="form-control @error('firstname') is-invalid @enderror"
                            id="firstName1" type="text" placeholder="Enter your first name"
                            value="{{Auth::user()->firstname}}" readonly />
                        @error('firstname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="middleName1">Last name</label>
                        <input name="lastname" class="form-control @error('lastname') is-invalid @enderror"
                            id="middleName1" type="text" placeholder="Enter your middle name"
                            value="{{Auth::user()->lastname}}" readonly />
                        @error('lastname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="haddress">Address:</label>
                        <input name="address" class="form-control @error('address') is-invalid @enderror"
                            value="{{Auth::user()->address}}" id="address" placeholder="Address"  readonly />
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="huser_state">State:</label>
                        <input name="user_state" class="form-control @error('user_state') is-invalid @enderror"
                            value="{{Auth::user()->user_state->name}}" id="user_state" placeholder="user_state"  readonly />
                        @error('user_state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="huser_lga">LGA:</label>
                        <input name="user_lga" class="form-control @error('user_lga') is-invalid @enderror"
                            value="{{Auth::user()->user_lga->name}}" id="user_lga" placeholder="user_lga"  readonly />
                        @error('user_lga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <h4>Shop Details</h4>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class="ul-form__label">Shop Name:</label>
                        <input name="shop_name" class="form-control @error('shop_name') is-invalid @enderror"
                        value="{{ Auth::user()->shop_name }}"
                        id="shop_name" placeholder="Enter shop name" readonly />
                        @error('shop_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Shop Phone:</label>
                        <input name="shop_phone" class="form-control @error('shop_phone') is-invalid @enderror"
                        value="{{ Auth::user()->shop_phone }}"
                        id="shop_phone" placeholder="Enter shop phone" readonly />
                        @error('shop_phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Shop Email:</label>
                        <input type="email" name="shop_email" class="form-control @error('shop_email') is-invalid @enderror"
                        value="{{ Auth::user()->shop_email }}"
                        id="shop_email" placeholder="Enter shop email" readonly />
                        @error('shop_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Shop Address:</label>
                        <input name="shop_address" class="form-control @error('shop_address') is-invalid @enderror"
                        value="{{ Auth::user()->shop_address }}"
                        id="shop_address" placeholder="Enter shop address" readonly />
                        @error('shop_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Town/City:</label>
                        <input name="city" class="form-control @error('city') is-invalid @enderror"
                        value="{{ Auth::user()->shop_city }}"
                        id="city" placeholder="Enter Town/City" readonly />
                        @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col-md-3 form-group d-flex flex-column justify-content-between">
                        <label for="huser_state">State:</label>
                        <input name="state" class="form-control @error('user_state') is-invalid @enderror"
                            value="{{Auth::user()->user_state->name}}" id="user_state" placeholder="user_state"  readonly />
                        @error('user_state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-3 form-group d-flex flex-column justify-content-between">
                        <label for="huser_lga">LGA:</label>
                        <input name="lga" class="form-control @error('user_lga') is-invalid @enderror"
                            value="{{Auth::user()->user_lga->name}}" id="user_lga" placeholder="user_lga"  readonly />
                        @error('user_lga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="custom-separator"></div>
                <h4>Prescribed Fees(Non-Transferable/Non-Refundable)</h4>
                <div class="table-responsive">
                    <table id="" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">S/N</th>
                                <th scope="col">Description</th>
                                <th scope="col">Fee</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(config('custom.ppmv-registration-fees') as $registrationFee)
                            <tr>
                                <td>{{$registrationFee['id']}}</td>
                                <td>NGN {{$registrationFee['description']}}</td>
                                <td>NGN {{number_format($registrationFee['fee'])}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="custom-separator"></div>
                
                <div class="card-footer">
                    <div class="mc-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn  btn-primary m-1" id="save" name="save">Submit Registration
                                    Application</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @else
                <div class="alert alert-card alert-warning" role="alert">
                    {{app('App\Http\Services\PPMVApplicationInfo')->canSubmitPPMVFacilityApplication()['message']}}
                </div>
            @endif
        </div>
    </div>
</div>
<script>
// Birth Certificate Photo on upload preview 
birth_certificate.onchange = evt => {
    const [file] = birth_certificate.files
    if (file) {
        $('#birth_certificatepreviewLabel').html(file.name);
    }
}

// Educational Certificate Photo on upload preview 
educational_certificate.onchange = evt => {
    const [file] = educational_certificate.files
    if (file) {
        $('#educational_certificatepreviewLabel').html(file.name);
    }
}

// Income Tax Certificate Photo on upload preview 
income_tax.onchange = evt => {
    const [file] = income_tax.files
    if (file) {
        $('#income_taxpreviewLabel').html(file.name);
    }
}

//Hand Written Certificate Photo on upload preview 
handwritten_certificate.onchange = evt => {
    const [file] = handwritten_certificate.files
    if (file) {
        $('#handwritten_certificatepreviewLabel').html(file.name);
    }
}

//Reference Letter 1 on upload preview 
reference_1_letter.onchange = evt => {
    const [file] = reference_1_letter.files
    if (file) {
        $('#reference_1_letterpreviewLabel').html(file.name);
    }
}

//Reference Letter 2 on upload preview 
reference_2_letter.onchange = evt => {
    const [file] = reference_2_letter.files
    if (file) {
        $('#reference_2_letterpreviewLabel').html(file.name);
    }
}


</script>
@endsection