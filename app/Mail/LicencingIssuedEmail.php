<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LicencingIssuedEmail extends Mailable
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
            $subject = 'Facility Inspection Application Licence Issued';
        }
        if($this->newData['registration_type'] == 'hospital_pharmacy_renewal'){
            $subject = 'Facility Inspection Application Licence Issued';
        }

        return $this->markdown('mail.licence-issued',['data'=>$this->newData])->subject($subject);
    }
}
