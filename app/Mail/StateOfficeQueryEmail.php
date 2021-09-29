<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StateOfficeQueryEmail extends Mailable
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
        if($this->newData['registration_type'] == 'hospital_pharmacy'){
            $subject = 'Facility Inspection Application Document Review Query';
        }
        if($this->newData['registration_type'] == 'ppmv'){
            $subject = 'Facility Location Inspection Application Document Review Query';
        }

        return $this->markdown('mail.state-offcie-query',['data'=>$this->newData])->subject($subject);
    }
}
