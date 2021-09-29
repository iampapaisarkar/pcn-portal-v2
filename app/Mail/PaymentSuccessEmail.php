<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessEmail extends Mailable
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
            $subject = 'PCN - Registration & Inspection Payment Notification';
        }
        if($this->newData['registration_type'] == 'hospital_pharmacy_renewal'){
            $subject = 'PCN - Renewal & Licence Payment Notification';
        }
        if($this->newData['registration_type'] == 'ppmv'){
            $subject = 'PCN - Inspection Payment Notification';
        }
        if($this->newData['registration_type'] == 'ppmv_registration'){
            $subject = 'PCN - Registration & Licence Payment Notification';
        }
        // if($this->newData['registration_type'] == 'ppmv_renewal'){
        //     $subject = 'PCN - Inspection Renewal Payment Notification';
        // }

        return $this->markdown('mail.payment-success',['data'=>$this->newData])->subject($subject);
    }
}
