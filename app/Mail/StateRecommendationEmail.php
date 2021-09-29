<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StateRecommendationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->newData = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->newData['registration_type'] == 'ppmv'){
            $subject = 'Facility Location Inspection Application Recommendation Notification';
        }
        if($this->newData['registration_type'] == 'ppmv_registration'){
            $subject = 'Facility Registration/Licence Application Document Review Recommendation';
        }

        return $this->markdown('mail.pharamcy-recommendation',['data'=>$this->newData])->subject($subject);
    }
}
