<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Services\EmailSend;

class EmailSendJOB implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public  $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->data['type'] == 'payment_success'){
            EmailSend::sendPaymentSuccessEMAIL($this->data);
        }
        if($this->data['type'] == 'state_office_query'){
            EmailSend::sendStateOfficeQueryEMAIL($this->data);
        }
        if($this->data['type'] == 'pharmacy_recommendation'){
            EmailSend::sendPharmacyRecommendationEMAIL($this->data);
        }
        if($this->data['type'] == 'licencing_issued'){
            EmailSend::sendLicencingIssuedEMAIL($this->data);
        }
    }
}
