<?php

namespace App\Mail\Ticket;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Open extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $recipient_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket, $recipient_name)
    {
        $this->ticket = $ticket;
        $this->recipient_name = $recipient_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name').' - New Ticket')
            ->markdown('mail.ticket.open');
    }
}
