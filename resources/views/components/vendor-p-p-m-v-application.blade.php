<div>
    <div class="row">
        <div class="col-md-12">
        <img style="width: 15%;" src="{{$application->user->photo ? asset('images/' . $application->user->photo) : asset('admin/dist-assets/images/avatar.jpg') }}" alt="">
        </div>

        <div class="col-md-4">
            <label for="inputEmail1" class="ul-form__label"><strong>First Name:</strong></label>
            <div>{{$application->user->firstname}}</div>
        </div>

        <!-- <div class="col-md-4">
            <label for="inputEmail1" class="ul-form__label"><strong>Middle Name:</strong></label>
            <div>Olubunmi</div>
        </div> -->

        <div class="col-md-4">
            <label for="inputEmail1" class="ul-form__label"><strong>Lastname:</strong></label>
            <div>{{$application->user->lastname}} </div>
        </div>

        <div class="col-md-4"> 
            <label for="inputEmail3" class="ul-form__label"><strong>Address:</strong></label>
            <div>{{$application->user->address}} </div>
        </div>

        <div class="col-md-4">
            <label for="inputEmail3" class="ul-form__label"><strong>State:</strong></label>
            <div>{{$application->user->user_state->name}} </div>
        </div>

        <div class="col-md-4">
            <label for="inputEmail3" class="ul-form__label"><strong>LGA:</strong> </label>
            <div>{{$application->user->user_lga->name}}</div>
        </div>
    </div>

    <div class="custom-separator"></div>
    <h4>Patent Medicine Vendor Shop</h4>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Shop Name:</strong></label>
            <div>{{$application->meptp->shop_name}}</div>
        </div>
        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Shop Phone:</strong></label>
            <div>{{$application->meptp->shop_phone}}</div>
        </div>

        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Shop Email:</strong></label>
            <div>{{$application->meptp->shop_email}}</div>
        </div>
        @if($application->ppmvl_no)
        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>PPMVL Number :</strong></label>
            <div>{{$application->meptp->ppmvl_no}}</div>
        </div>
        @endif
        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Shop Address:</strong></label>
            <div>{{$application->meptp->shop_address}}</div>
        </div>

        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Town/City:</strong></label>
            <div>{{$application->meptp->city}}</div>
        </div>

        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>State:</strong></label>
            <div>{{$application->meptp->user_state->name}}</div>
        </div>

        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>LGA:</strong></label>
            <div>{{$application->meptp->user_lga->name}}</div>
        </div>
    </div>

    <div class="custom-separator"></div>
    <h4>Reference 1 (Pharmacist)</h4>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Reference Name:</strong></label>
            <div>{{$application->reference_1_name}}</div>
        </div>
        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Reference Phone:</strong></label>
            <div>{{$application->reference_1_phone}}</div>
        </div>

        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Reference Email:</strong></label>
            <div>{{$application->reference_1_email}}</div>
        </div>
        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Current Annual Licence:</strong></label>
            <div>{{$application->current_annual_licence}}</div>
        </div>
        <div class="form-group col-md-6">
            <label for="inputEmail3" class="ul-form__label"><strong>Reference Address:</strong></label>
            <div>{{$application->reference_1_address}}</div>
        </div>
        <div class="col-md-4">
            <label for="inputEmail5" class="ul-form__label">Reference Letter:</label>
            <br />
            <a href="{{ route('download-ppmv-application-document') }}?id={{$application->id}}&user_id={{$application->user->id}}&type=reference_1_letter" class="btn btn-info">DOWNLOAD DOCUMENT</a>
        </div>
    </div>


    <div class="custom-separator"></div>
    <h4>Reference 2</h4>
    <div class="form-row">
    <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Reference Name:</strong></label>
            <div>{{$application->reference_2_name}}</div>
        </div>
        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Reference Phone:</strong></label>
            <div>{{$application->reference_2_phone}}</div>
        </div>

        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Reference Email:</strong></label>
            <div>{{$application->reference_2_email}}</div>
        </div>
        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Reference Occupation:</strong></label>
            <div>{{$application->reference_occupation}}</div>
        </div>
        <div class="form-group col-md-6">
            <label for="inputEmail3" class="ul-form__label"><strong>Reference Address:</strong></label>
            <div>{{$application->reference_2_address}}</div>
        </div>
        <div class="col-md-4">
            <label for="inputEmail5" class="ul-form__label">Reference Letter:</label>
            <br />
            <a href="{{ route('download-ppmv-application-document') }}?id={{$application->id}}&user_id={{$application->user->id}}&type=reference_2_letter" class="btn btn-info">DOWNLOAD DOCUMENT</a>
        </div>
    </div>
</div>