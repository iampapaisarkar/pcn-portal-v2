<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Activity;

class AllActivity extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $application_id, $app_type;
    public function __construct($applicationID, $type)
    {
        $this->application_id = $applicationID;
        $this->app_type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $activities = Activity::where('type', $this->app_type)->where('application_id', $this->application_id)
        ->latest()
        ->get();
        // dd(0);
        return view('components.all-activity', compact('activities'));
    }
}
