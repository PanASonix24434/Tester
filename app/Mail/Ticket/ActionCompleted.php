<?php

namespace App\Mail\Ticket;

use App\Enums\NotifyAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActionCompleted extends Mailable
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

        if (strcasecmp($this->action, NotifyAction::TAKEN_OWNERSHIP) === 0) {
            $subject .= ' - Ticket: '.$ticket->ref.' - Taken Ownership';
            $message = 'Ticket '.$ticket->ref.' has been taken ownership by '.$this->action_user.'.';
        } else if (strcasecmp($this->action, NotifyAction::TAKEN_OVER) === 0) {
            $subject .= ' - Ticket: '.$ticket->ref.' - Taken Over';
            $message = 'Ticket '.$ticket->ref.' has been taken over by '.$this->action_user.'.';
        } else if (strcasecmp($this->action, NotifyAction::ACKNOWLEDGED) === 0) {
            $subject .= ' - Ticket Acknowledged: '.$ticket->ref;
            $message = 'Ticket '.$ticket->ref.' has been acknowledged by '.$this->action_user.'.';
        } else if (strcasecmp($this->action, NotifyAction::ASSIGNED) === 0) {
            $subject .= ' - Ticket Assigned to '.$this->action_user.': '.$ticket->ref;
            $message = 'Ticket '.$ticket->ref.' has been assigned to '.$this->action_user.'.';
        } else if (strcasecmp($this->action, NotifyAction::ESCALATED) === 0) {
            $subject .= ' - Ticket Escalated to '.$this->action_user.': '.$ticket->ref;
            $message = 'Ticket '.$ticket->ref.' has been escalated to '.$this->action_user.'.';
        } else if (strcasecmp($this->action, NotifyAction::RESOLVED) === 0) {
            $subject .= ' - Ticket Resolved: '.$ticket->ref;
            $message = 'Ticket '.$ticket->ref.' has been resolved.';
        } else if (strcasecmp($this->action, NotifyAction::COMPLETED) === 0) {
            $subject .= ' - Ticket Completed: '.$ticket->ref;
            $message = 'Ticket '.$ticket->ref.' has been completed.';
        } else if (strcasecmp($this->action, NotifyAction::TERMINATED) === 0) {
            $subject .= ' - Ticket Terminated: '.$ticket->ref;
            $message = 'Ticket '.$ticket->ref.' has been terminated by '.$this->action_user.'.';
        } else if (strcasecmp($this->action, NotifyAction::REOPENED) === 0) {
            $subject .= ' - Ticket Reopened: '.$ticket->ref;
            $message = 'Ticket '.$ticket->ref.' has been reopened.';
        }

        return $this->subject($subject)
            ->markdown('mail.ticket.action_completed')
            ->with([
                'message' => $message,
            ]);
    }
}
