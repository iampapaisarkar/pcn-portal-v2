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
        if($this->newData['type'] == 'meptp_training'){
            $subject = 'MEPTP Payment Notification';
        }
        if($this->newData['type'] == 'ppmv_registration'){
            $subject = 'Licence Registration Payment';
        }
        if($this->newData['type'] == 'ppmv_renewal'){
            $subject = 'Licence Registration Payment';
        }

        return $this->markdown('mail.payment-success',['data'=>$this->newData])->subject($subject);
    }
}
