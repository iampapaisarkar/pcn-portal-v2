<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\PPMVApplication;
use App\Models\Service;
use App\Models\ServiceFeeMeta;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class VendorPPMVApplication extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $application_id, $vendor_id;
    public function __construct($applicationID, $vendorID)
    {
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
        $application = PPMVApplication::select('p_p_m_v_applications.*')
        ->join('p_p_m_v_renewals', 'p_p_m_v_renewals.ppmv_application_id', 'p_p_m_v_applications.id')
        ->where('p_p_m_v_renewals.payment', true)
        ->where('p_p_m_v_applications.id', $this->application_id)
        ->where('p_p_m_v_applications.vendor_id', $this->vendor_id)
        ->with('user', 'meptp')
        ->first();

        return view('components.vendor-p-p-m-v-application', compact('application'));
    }
}
