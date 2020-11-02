<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Utility;
use Auth;

class PoMail extends Mailable
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
        $subject = 'Purchase Order';
        $name = 'Company Name';
        $company = Utility::companyInfo();
        if(!empty($company)){

            $address = $company->email;
            $subject = $company->name.' Info';
            $name = $company->name;
        }

        $message = $this->from(Utility::DEFAULT_MAIL)->view('mail_views.purchase_order');
            $message->from(Utility::DEFAULT_MAIL, $name);/*
            ->cc($address, $name)
            ->bcc($address, $name)
            ->replyTo($address, $name)*/
            $message->subject($subject);
        if(count($this->data['attachment']) > 0){
            foreach($this->data['attachment'] as $file){
                $message->attach($file);
            }
        }

        if(count($this->data['copy']) > 0){
            foreach($this->data['copy'] as $copy){
                $message->cc($copy);
            }
        }

            $message->with([ 'message' => $this->data,'itemComponents' => $this->data['poData'],
             'itemDetail' => $this->data['po'], 'currencyCode' => $this->data['currency'] ]);
        return $message;
    }
}
