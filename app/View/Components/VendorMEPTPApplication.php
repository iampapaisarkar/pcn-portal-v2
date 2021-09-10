<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\MEPTPApplication;
use App\Models\Service;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class VendorMEPTPApplication extends Component
{
    // protected $applicationID, $vendorID;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $application_id, $vendor_id;
    public function __construct($applicationID, $vendorID)
    {
        // $this->applicationID = $applicationID;
        // $this->vendorID = $vendorID;
        $this->application_id = $applicationID;
        $this->vendor_id = $vendorID;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {   
        $application = MEPTPApplication::where('vendor_id',  $this->vendor_id)
        ->where('id',  $this->application_id)
        // ->join('batches', 'batches.id', 'm_e_p_t_p_applications.batch_id')->where('batches.status', '=', true)
        // ->where('m_e_p_t_p_applications.status', '!=', 'approved_card_generated')
        // ->orWhere('m_e_p_t_p_applications.status', '!=', 'rejected')
        // ->select('m_e_p_t_p_applications.*')
        ->with('user.user_state','user.user_lga', 'user_state', 'user_lga', 'tier', 'indexNumber', 'result')
        ->first();

        return view('components.vendor-m-e-p-t-p-application', compact('application'));
    }
}
