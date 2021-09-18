<div>
    <div class="row">
        <div class="col-md-12">
        <img style="width: 15%;" src="{{$application->user->photo ? asset('images/' . $application->user->photo) : asset('admin/dist-assets/images/avatar.jpg') }}" alt="">
        </div>

        <div class="col-md-4">
            <label for="inputEmail1" class="ul-form__label"><strong>First Name:</strong></label>
            <div>{{$application->user->firstname}}</div>
        </div>


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

    <h4>Shop Details</h4>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Shop Name:</strong></label>
            <div>{{$application->user->shop_name}}</div>
        </div>
        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Shop Phone:</strong></label>
            <div>{{$application->user->shop_phone}}</div>
        </div>

        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Shop Email:</strong></label>
            <div>{{$application->user->shop_email}}</div>
        </div>
        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Shop Address:</strong></label>
            <div>{{$application->user->shop_address}}</div>
        </div>

        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>Town/City:</strong></label>
            <div>{{$application->user->shop_city}}</div>
        </div>

        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>State:</strong></label>
            <div>{{$application->user->user_state->name}}</div>
        </div>

        <div class="form-group col-md-3">
            <label for="inputEmail3" class="ul-form__label"><strong>LGA:</strong></label>
            <div>{{$application->user->user_state->name}}</div>
        </div>
    </div>
</div>