<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Utility;

class WarehouseMail extends Mailable
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

        return $this->view('mail_views.warehouse')
            ->from($address, $name)/*
            ->cc($address, $name)
            ->bcc($address, $name)
            ->replyTo($address, $name)*/
            ->subject($this->data['subject'])
            ->with([ 'message' => $this->data['message'] ]);
    }

}
