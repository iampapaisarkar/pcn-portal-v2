<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InspectionRecommendationEmail extends Mailable
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
        if($this->newData['registration_type'] == 'community_pharmacy'){
            if($this->newData['status'] == 'full_recommendation'){
                $subject = 'Facility Inspection Application Approval';
            }
            if($this->newData['status'] == 'no_recommendation'){
                $subject = 'Facility Inspection Application Query';
            }
        }

        if($this->newData['registration_type'] == 'distribution_premises'){
            if($this->newData['status'] == 'full_recommendation'){
                $subject = 'Facility Inspection Application Approval';
            }
            if($this->newData['status'] == 'no_recommendation'){
                $subject = 'Facility Inspection Application Query';
            }
        }

        return $this->markdown('mail.inspection-recommendation',['data'=>$this->newData])->subject($subject);
    }
}
