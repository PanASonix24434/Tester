<?php

namespace App\Mail\Ticket;

use App\Enums\NotifyAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendingAction extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $recipient_name;
    public $action;
    public $action_user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket, $recipient_name, $action, $action_user = null)
    {
        $this->ticket = $ticket;
        $this->recipient_name = $recipient_name;
        $this->action = $action;
        $this->action_user = $action_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $ticket = $this->ticket;
        $subject = config('app.name');
        $message = '';

        if (strcasecmp($this->action, NotifyAction::OPEN) === 0) {
            $subject .= ' - New Ticket: '.$ticket->ref;
            $message = $ticket->created_by_name.' has open a new ticket.';
        } else if (strcasecmp($this->action, NotifyAction::ASSIGN_GROUP) === 0) {
            $subject .= ' - Ticket Assigned to My Group: '.$ticket->ref;
            $message = $this->action_user.' has been assigned a ticket to your group.';
        } else if (strcasecmp($this->action, NotifyAction::REASSIGN_GROUP) === 0) {
            $subject .= ' - Ticket Reassigned to My Group: '.$ticket->ref;
            $message = $this->action_user.' has been reassigned a ticket to your group.';
        } else if (strcasecmp($this->action, NotifyAction::ASSIGN) === 0) {
            $subject .= ' - Ticket Assigned to Me: '.$ticket->ref;
            $message = $this->action_user.' has been assigned a ticket to you.';
        } else if (strcasecmp($this->action, NotifyAction::ESCALATE) === 0) {
            $subject .= ' - Ticket Escalated to Me: '.$ticket->ref;
            $message = $this->action_user.' has been escalated a ticket to you.';
        }

        return $this->subject($subject)
            ->markdown('mail.ticket.pending_action')
            ->with([
                'message' => $message,
            ]);
    }
}
