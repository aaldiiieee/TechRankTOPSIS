<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $feedbackUrl;

    public function __construct($customer, $feedbackUrl)
    {
        $this->customer = $customer;
        $this->feedbackUrl = $feedbackUrl;
    }

    public function build()
    {
        return $this->subject('Laporan Servis Anda')
                    ->view('emails.report')
                    ->with([
                        'customer' => $this->customer,
                        'feedbackUrl' => $this->feedbackUrl,
                    ]);
    }
}
