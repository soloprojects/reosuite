<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\AppraisalMail;
use Illuminate\Support\Facades\Mail;

class SendAppraisalEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    private $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($toEmail,$data)
    {
        //
        $this->data = $data;
        $this->email = $toEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->email)->send(new AppraisalMail($this->data));

    }
}
