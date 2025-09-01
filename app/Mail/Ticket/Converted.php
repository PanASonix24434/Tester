<?php

namespace App\Mail\Ticket;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Converted extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $recipient_name;
    public $old_type;
    public $new_type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket, $recipient_name, $old_type, $new_type)
    {
        $this->ticket = $ticket;
        $this->recipient_name = $recipient_name;
        $this->old_type = $old_type;
        $this->new_type = $new_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $ticket = $this->ticket;
        $subject = config('app.name').' - Ticket Converted: '.$ticket->ref;
        $message = 'Ticket '.$ticket->ref.' has been converted from <b>'.title($this->old_type).'</b> to <b>'.title($this->new_type).'</b>';
        return $this->subject($subject)
            ->markdown('mail.ticket.converted')
            ->with([
                'message' => $message,
            ]);
    }
}
