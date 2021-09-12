<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Registration;
use App\Models\HospitalRegistration;

class HospitalPharmacyPreview extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $registration_id, $user_id;
    public function __construct($registrationID, $userID)
    {
        $this->registration_id = $registrationID;
        $this->user_id = $userID;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $registration = Registration::where(['payment' => true, 'id' => $this->registration_id, 'user_id' => $this->user_id, 'type' => 'hospital_pharmacy'])
        ->with('hospital_pharmacy', 'user')
        ->first();

        return view('components.hospital-pharmacy-preview', compact('registration'));
    }
}
