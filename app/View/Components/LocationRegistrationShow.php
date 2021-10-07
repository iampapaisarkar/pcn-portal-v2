<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Registration;
use App\Models\OtherRegistration;

class LocationRegistrationShow extends Component
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
        ->with('other_registration', 'user')
        ->first();

        return view('components.location-registration-show', compact('registration'));
    }
}
