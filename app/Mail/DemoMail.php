<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Utility;

class DemoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $address = 'info@company.com';
        $subject = 'Company Info!';
        $name = 'Company Name';
        $company = Utility::companyInfo();
        if(!empty($company)){

            $address = $company->email;
            $subject = $company->name.' Info';
            $name = $company->name;
        }
        return $this->view('requisition.send_request')
            ->from(Utility::DEFAULT_MAIL, $name)/*
            ->cc($address, $name)
            ->bcc($address, $name)
            ->replyTo($address, $name)*/
            ->subject($subject)
            ->with([ 'message' => $this->data ]);
    }

}
