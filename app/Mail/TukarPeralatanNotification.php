<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TukarPeralatanNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $resultDetails;

    /**
     * Create a new message instance.
     *
     * @param array $resultDetails
     */
    public function __construct($resultDetails)
    {
        $this->resultDetails = $resultDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Tukar Peralatan Notification')
            ->view('emails.tukar_peralatan')
            ->with('resultDetails', $this->resultDetails);
    }
}
