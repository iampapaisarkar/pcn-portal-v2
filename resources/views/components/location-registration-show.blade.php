<div>
    <div class="card-body">
            <h4>Company Details</h4>
            <div class="custom-separator"></div>
            <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputEmail1" class="ul-form__label"><strong>Company Name:</strong></label>
                <div>{{$registration->other_registration->company->name}}</div>
                
            </div>
            
            <div class="form-group col-md-8">
                <label for="inputEmail1" class="ul-form__label"><strong>Company Address:</strong></label>
                <div>{{$registration->other_registration->company->address}}</div>
            </div>
            
            <div class="form-group col-md-4">
                <label for="inputEmail1" class="ul-form__label"><strong>Category of Practise:</strong></label>
                <div>{{$registration->other_registration->company->category}}</div>
            </div>
            
            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>State:</strong></label>
                <div>{{$registration->other_registration->company->company_state->name}}</div>
            </div>
            <div class="form-group col-md-4">
            
                <label for="inputEmail3" class="ul-form__label"><strong>LGA: </strong></label>
                <div>{{$registration->other_registration->company->company_state->name}}</div>
            </div>

            @if(Auth::user()->hasRole(['distribution_premises']))
            <div class="form-group col-md-12">
                <label for="inputEmail3" class="ul-form__label"><strong>Sub Catrgory: </strong></label>
                <div>{{App\Models\ServiceFeeMeta::where('id', $registration->other_registration->company->sub_category)->first()->description}}</div>
            </div>
            @endif
        </div>
        
        <div class="custom-separator"></div>
        
        
        <h4>Pharmacist In Control of Business</h4>
        <div class="custom-separator"></div>
        <div class="form-row">	
            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>Name of Pharmacist:</strong></label>
                <div>{{$registration->other_registration->company->business->name}}</div>
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>Full Registration Number:</strong></label>
                
                <div>{{$registration->other_registration->company->business->registration_number}}</div>
            </div>
            <div class="form-group col-md-4">
                <img src="{{asset('images/' . $registration->other_registration->company->business->passport)}}" alt="" class="w-50">
            </div>
            
        </div>
        <div class="custom-separator"></div>
        <h4>Pharmacist Directors (as in CAC Form C.O.7)</h4> 
        <div class="custom-separator"></div>
        <div class="form-row">

        @foreach($registration->other_registration->company->director as $director)
            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>Full Name:</strong></label>
                
                <div>{{$director->name}}</div>
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>Full Registration Number:</strong></label>
                
                <div>{{$director->registration_number}}</div>
            </div>

            <div class="form-group col-md-4">
                <label for="inputEmail3" class="ul-form__label"><strong>Current Annual Licence Number:</strong></label>
                
                <div>{{$director->licence_number}}</div>
            </div>
        @endforeach
        </div>
        <div class="custom-separator"></div>
        <h4>Other Directors (as in CAC Form C.O.7)</h4> 
        <div class="custom-separator"></div>
        <div class="form-row">
        @foreach($registration->other_registration->company->other_director as $other_director)
            <div class="form-group col-md-6">
                <label for="inputEmail3" class="ul-form__label"><strong>Full Name:</strong></label>
                
                <div>{{$other_director->name}}</div>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail3" class="ul-form__label"><strong>Profession:</strong></label>
                
                <div>{{$other_director->profession}}</div>
            </div>
        @endforeach
        </div>
        <div class="custom-separator"></div>
        <h4>Superintendent Pharmacist</h4>
        

        <div class="custom-separator"></div>
        <div class="form-row">
        
            <div class="form-group col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>First Name:</strong></label>
                    <div>{{$registration->other_registration->firstname}}</div>
            </div>
            <div class="form-group col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>Middle Name:</strong></label>
                    <div>{{$registration->other_registration->middlename}}</div>
            </div>
            <div class="form-group col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>Last Name:</strong></label>
                    <div>{{$registration->other_registration->surname}}</div>
            </div>
            <div class="form-group col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>Phone:</strong></label>
                    <div>{{$registration->other_registration->phone}}</div>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>Email:</strong></label>
                    <div>{{$registration->other_registration->email}}</div>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>Gender:</strong></label>
                    <div>{{$registration->other_registration->gender}}</div>
                </div>
                
                <div class="form-group col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>Date of Qualification:</strong></label>
                    <div>{{Carbon\Carbon::parse($registration->other_registration->doq)->format('d M Y')}}</div>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>Current Residential Address:</strong></label>
                    <div>{{$registration->other_registration->residental_address}}</div>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail3" class="ul-form__label"><strong>Last Annual Licence Number.:</strong></label>
                    <div>{{$registration->other_registration->annual_licence_no}}</div>
                </div>
                                        
            </div>
        <div class="custom-separator"></div>
    </div>
</div>