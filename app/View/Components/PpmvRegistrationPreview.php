<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Registration;

class PpmvRegistrationPreview extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $application_id, $user_id;
    public function __construct($applicationID, $userID)
    {
        $this->application_id = $applicationID;
        $this->user_id = $userID;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $application = Registration::where(['id' => $this->application_id, 'user_id' => $this->user_id, 'type' => 'ppmv'])
        ->with('ppmv', 'user')
        ->first();

        return view('components.ppmv-registration-preview', compact('application'));
    }
}
