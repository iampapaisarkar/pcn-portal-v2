<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Registration;
use App\Models\OtherRegistration;

class ManufacturingRegistrationShow extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $registration_id, $user_id, $type;
    public function __construct($registrationID, $userID, $type)
    {
        $this->registration_id = $registrationID;
        $this->user_id = $userID;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $registration = Registration::where(['id' => $this->registration_id, 'user_id' => $this->user_id, 'type' => $this->type])
        ->with('other_registration.company.company_state',
        'other_registration.company.company_state',
        'other_registration.company.company_lga',
        'other_registration.company.business',
        'other_registration.company.director',
        'other_registration.company.other_director',
        'user')
        ->first();

        return view('components.manufacturing-registration-show', compact('registration'));
    }
}
