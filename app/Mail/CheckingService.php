<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CheckingService extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $service;
    public $requester;
    public $result;

    public function __construct($service, $requester, $result)
    {
        $this->service = $service;
        $this->requester = $requester;
        $this->result = $result;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->subject('Kết qủa cho dịch vụ '.$this->service)
        ->markdown('emails.resultForCheckingService');
    }
}
