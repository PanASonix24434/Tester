<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplaintTest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    protected $data; 
    public function __construct($data)
    {
        $this->data = $data;

        //dd($data['complaint_no']);
    }

    /*public function __construct()
    {

    }*/

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Aduan Sistem e-Lesen 2.0 Telah Diselesaikan',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        //dd($this->data['complaint_no']);

        return new Content(
            view: 'mail.complainttest',
            with: [
                'complaintNo' => sprintf('%06d', $this->data['complaint_no']),
                'complaintRemark' => $this->data['complaint_remark'],
            ],
        );

    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
