@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Location Approval', 'route' => 'ppmv-application-form'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card-body">
            <form method="POST" action="{{ route('ppmv-application-update', $application->id) }}" enctype="multipart/form-data" novalidate>
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


                    <div id="ppmvl_noField" style="{{old('is_registered') == 'yes' ? 'display: block;' : 'display: none;'}}" class="form-group col-md-4">
                        <label for="inputEmail3" class="ul-form__label">PPMVL Number :</label>
                        <input name="ppmvl_no" class="form-control @error('ppmvl_no') is-invalid @enderror"
                        value="{{old('ppmvl_no')}}"
                        id="ppmvl_no" placeholder="Enter Town/ppmvl_no" />
                        @error('ppmvl_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="custom-separator"></div>
                <h4>Documents Upload</h4>


                <div class="custom-separator"></div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="picker1">Birth Certificate or Declaration of Age: (PDF)</label>
                        <div class="custom-file mb-3">
                            <input name="birth_certificate" type="file" name="color_passportsize" class="custom-file-input
                            @error('birth_certificate') is-invalid @enderror" accept="application/pdf"
                                id="birth_certificate">
                            <label class="custom-file-label " for="birth_certificate"
                                aria-describedby="birth_certificate" id="birth_certificatepreviewLabel">{{$application->ppmv->birth_certificate}}</label>
                            @error('birth_certificate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="picker1">Educational Credentials: (PDF)</label>
                        <div class="custom-file mb-3">
                            <input name="educational_certificate" type="file" name="color_passportsize" class="custom-file-input
                            @error('educational_certificate') is-invalid @enderror" accept="application/pdf"
                                id="educational_certificate">
                            <label class="custom-file-label " for="educational_certificate"
                                aria-describedby="educational_certificate" id="educational_certificatepreviewLabel">{{$application->ppmv->educational_certificate}}</label>
                            @error('educational_certificate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="picker1">3 Years Income Tax Clearance: (PDF)</label>
                        <div class="custom-file mb-3">
                            <input name="income_tax" type="file" name="color_passportsize" class="custom-file-input
                            @error('income_tax') is-invalid @enderror" accept="application/pdf"
                                id="income_tax">
                            <label class="custom-file-label " for="income_tax"
                                aria-describedby="income_tax" id="income_taxpreviewLabel">{{$application->ppmv->income_tax}}</label>
                            @error('income_tax')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="picker1">Handwritten Application for Location Inspection addressed to The Registrar: (PDF)</label>
                        <div class="custom-file mb-3">
                            <input name="handwritten_certificate" type="file" name="color_passportsize" class="custom-file-input
                            @error('handwritten_certificate') is-invalid @enderror" accept="application/pdf"
                                id="handwritten_certificate">
                            <label class="custom-file-label " for="handwritten_certificate"
                                aria-describedby="handwritten_certificate" id="handwritten_certificatepreviewLabel">{{$application->ppmv->handwritten_certificate}}</label>
                            @error('handwritten_certificate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="custom-separator"></div>

                <h4>Reference 1</h4>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Reference Name:</label>
                        <input name="reference_1_name" class="form-control @error('reference_1_name') is-invalid @enderror"
                        value="{{$application->ppmv->reference_1_name}}"
                        id="reference_1_name" placeholder="Enter name" />
                        @error('reference_1_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Reference Phone:</label>
                        <input name="reference_1_phone" class="form-control @error('reference_1_phone') is-invalid @enderror"
                        value="{{$application->ppmv->reference_1_phone}}"
                        id="reference_1_phone" placeholder="Enter phone" />
                        @error('reference_1_phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Reference Email:</label>
                        <input type="email" name="reference_1_email" class="form-control @error('reference_1_email') is-invalid @enderror"
                        value="{{$application->ppmv->reference_1_email}}"
                        id="reference_1_email" placeholder="Enter email" />
                        @error('reference_1_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Current Annual Licence:</label>
                        <input name="current_annual_licence" class="form-control @error('current_annual_licence') is-invalid @enderror"
                        value="{{$application->ppmv->current_annual_licence}}"
                        id="current_annual_licence" placeholder="Enter licence no" />
                        @error('current_annual_licence')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class="ul-form__label">Reference Address:</label>
                        <input type="text" name="reference_1_address" class="form-control @error('reference_1_address') is-invalid @enderror"
                        value="{{$application->ppmv->reference_1_address}}"
                        id="reference_1_address" placeholder="Enter address" />
                        @error('reference_1_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 d-flex flex-column justify-content-between">
                        <label for="picker1">Reference Letter:</label>
                        <div class="custom-file">
                            <input name="reference_1_letter" type="file" name="color_passportsize" class="custom-file-input
                            @error('reference_1_letter') is-invalid @enderror" accept="application/pdf"
                                id="reference_1_letter" accept="image/*">
                            <label class="custom-file-label " for="reference_1_letter"
                                aria-describedby="reference_1_letter" id="reference_1_letterpreviewLabel">{{$application->ppmv->reference_1_letter}}</label>
                            @error('reference_1_letter')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="custom-separator"></div>

                <h4>Reference 2</h4>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Reference Name:</label>
                        <input name="reference_2_name" class="form-control @error('reference_2_name') is-invalid @enderror"
                        value="{{$application->ppmv->reference_2_name}}"
                        id="reference_2_name" placeholder="Enter name" />
                        @error('reference_2_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Reference Phone:</label>
                        <input name="reference_2_phone" class="form-control @error('reference_2_phone') is-invalid @enderror"
                        value="{{$application->ppmv->reference_2_phone}}"
                        id="reference_2_phone" placeholder="Enter phone" />
                        @error('reference_2_phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Reference Email:</label>
                        <input type="email" name="reference_2_email" class="form-control @error('reference_2_email') is-invalid @enderror"
                        value="{{$application->ppmv->reference_2_email}}"
                        id="reference_2_email" placeholder="Enter email" />
                        @error('reference_2_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail3" class="ul-form__label">Reference Occupation:</label>
                        <input name="reference_occupation" class="form-control @error('reference_occupation') is-invalid @enderror"
                        value="{{$application->ppmv->reference_occupation}}"
                        id="reference_occupation" placeholder="Enter occupation" />
                        @error('reference_occupation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class="ul-form__label">Reference Address:</label>
                        <input type="text" name="reference_2_address" class="form-control @error('reference_2_address') is-invalid @enderror"
                        value="{{$application->ppmv->reference_2_address}}"
                        id="reference_2_address" placeholder="Enter address" />
                        @error('reference_2_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 d-flex flex-column justify-content-between">
                        <label for="picker1">Reference Letter:</label>
                        <div class="custom-file">
                            <input name="reference_2_letter" type="file" name="color_passportsize" class="custom-file-input
                            @error('reference_2_letter') is-invalid @enderror" accept="application/pdf"
                                id="reference_2_letter" accept="image/*">
                            <label class="custom-file-label " for="reference_2_letter"
                                aria-describedby="reference_2_letter" id="reference_2_letterpreviewLabel">{{$application->ppmv->reference_2_letter}}</label>
                            @error('reference_2_letter')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-row mt-5">
                    <div class="form-group col-md-12">
                    I as an applicant for a Patent and Proprietary Medicines Vendor's License residing hereby make the foregoing solemnly and consciously believing same to be true and correct.
                    <label class="checkbox checkbox-primary mr-2 @error('terms') is-invalid @enderror">
                        <input name="terms" type="checkbox" value="I accept">
                        <span>I Accept</span>
                        <span class="checkmark"></span>
                    </label>
                    </div>
                    @error('terms')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="custom-separator"></div>
                
                <div class="card-footer">
                    <div class="mc-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn  btn-primary m-1" id="save" name="save">Submit Location Approval
                                    Application</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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