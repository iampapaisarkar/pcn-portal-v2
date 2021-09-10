<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Services\EmailSend;

class GenerateLicenceEmailJOB implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $licence;
    public $vendor;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->licence = $data['licence'];
        $this->vendor = $data['vendor'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        EmailSend::sendLicenceGenerateEMAIL($this->licence, $this->vendor);
    }
}
