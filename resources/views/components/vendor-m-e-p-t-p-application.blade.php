<div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-6">
                <img style="width: 25%;" src="{{$application->user->photo ? asset('images/' . $application->user->photo) : asset('admin/dist-assets/images/avatar.jpg') }}" alt="">
            </div>
            <div class="form-group col-md-6">
                <h3>Batch Details: {{$application->batch->batch_no}}/{{$application->batch->year}}<h3>
                @if($application->tier && $application->indexNumber == null)
                <h3>Tier: {{$application->tier->name}}<h3>
                @endif
                @if($application->indexNumber)
                {{$application->indexNumber->arbitrary_1 .'/'. $application->indexNumber->arbitrary_2 .'/'. $application->indexNumber->batch_year .'/'. $application->indexNumber->state_code .'/'. $application->indexNumber->school_code .'/'. $application->indexNumber->tier .'/'. $application->indexNumber->id}}
                @endif

                @if(!Auth::user()->hasROle(['vendor']))
                    @if($application->result && $application->result->status != 'pending')
                        @if($application->result->status == 'pass')
                        <span class="badge badge-pill badge-success">PASS</span>
                        <h5>Score: <strong>{{$application->result->score}}</strong></h5>
                        <h5>Percentage: <strong>{{$application->result->percentage}}%</strong></h5>
                        @else
                        <span class="badge badge-pill badge-danger">FAILED</span>
                        <h5>Score: <strong>{{$application->result->score}}</strong></h5>
                        <h5>Percentage: <strong>{{$application->result->percentage}}%</strong></h5>
                        @endif
                    @endif
                @endif
            </div>
            <div class="col-md-4">
                <label for="inputEmail1" class="ul-form__label"><strong>First Name:</strong></label>
                <div>{{$application->user->firstname}} </div>
            </div>

            <div class="col-md-4">
                <label for="inputEmail1" class="ul-form__label"><strong>Last Name:</strong></label>
                <div>{{$application->user->lastname}}</div>
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

        <h4>Uploaded Documents</h4>
        <div class="custom-separator"></div>
        <div class="row">
            <div class="col-md-4">
                <label for="inputEmail5" class="ul-form__label">Birth Certificate or Declaration of Age:</label>
                <br /><a href="{{ route('download-meptp-application-document') }}?id={{$application->id}}&user_id={{$application->user->id}}&type=birth_certificate" class="btn btn-info">DOWNLOAD DOCUMENT</a>
            </div>
            <div class="col-md-4">
                <label for="inputEmail5" class="ul-form__label">Educational Credentials:</label>
                <br /><a href="{{ route('download-meptp-application-document') }}?id={{$application->id}}&user_id={{$application->user->id}}&type=educational_certificate" class="btn btn-info">DOWNLOAD DOCUMENT</a>
            </div>
            <div class="col-md-4">
                <label for="inputEmail5" class="ul-form__label">Health Related Academic Training
                    Credentials:</label>
                <br /><a href="{{ route('download-meptp-application-document') }}?id={{$application->id}}&user_id={{$application->user->id}}&type=academic_certificate" class="btn btn-info">DOWNLOAD DOCUMENT</a>
            </div>
        </div>

        <div class="custom-separator"></div>

        <h4>Patent Medicine Vendor Shop</h4>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>Shop Name:</strong></label>
                <div>{{$application->shop_name}}</div>
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>Shop Phone:</strong></label>
                <div>{{$application->shop_phone}}</div>
            </div>

            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>Shop Email:</strong></label>
                <div>{{$application->shop_email}}</div>
            </div>
            <div class="form-group col-md-3">
                <label for="inputEmail3" class="ul-form__label"><strong>Shop Address:</strong></label>
                <div> {{$application->shop_address}}
                </div>
            </div>

            <div class="form-group col-md-3">
                <label for="inputEmail3" class="ul-form__label"><strong>Town/City:</strong></label>
                <div>{{$application->city}}</div>
            </div>

            <div class="form-group col-md-3">
                <label for="inputEmail3" class="ul-form__label"><strong>State:</strong></label>
                <div>{{$application->user_state->name}}</div>
            </div>

            <div class="form-group col-md-3">
                <label for="inputEmail3" class="ul-form__label"><strong>LGA:</strong></label>
                <div>{{$application->user_lga->name}}</div>
            </div>

            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>Are you registered?</strong> </label>
                <div>{{$application->is_registered ? 'Yes' : 'No'}}</div>
            </div>

            @if($application->is_registered)
            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>PPMVL Number :</strong></label>
                <div>{{$application->ppmvl_no}}</div>
            </div>
            @endif
        </div>

        <div class="custom-separator"></div>

        <h4>Training Centre</h4>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail3" class="ul-form__label"><strong>Preferred Training Centre</strong></label>
                <div class="input-right-icon">{{$application->school->name}}</div>
            </div>
        </div>
    </div>
</div>

