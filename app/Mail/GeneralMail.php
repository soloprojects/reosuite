<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Utility;
use Auth;

class GeneralMail extends Mailable
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

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'info@company.com';
        $subject = 'Quote';
        $name = 'Company Name';
        $company = Utility::companyInfo();
        if(!empty($company)){

            $address = $company->email;
            $subject = $company->name.' Info';
            $name = $company->name;
        }

        $fromEmail = (isset($this->data['fromEmail'])) ? $this->data['fromEmail'] : $address;
        $message = $this->from(Utility::DEFAULT_MAIL)->view('mail_views.general');
        $message->from(Utility::DEFAULT_MAIL, $name);/*
            ->cc($address, $name)
            ->bcc($address, $name)
            ->replyTo($address, $name)*/
        $message->subject($subject);


        $message->with([ 'message' => $this->data ]);
        return $message;
    }
}
