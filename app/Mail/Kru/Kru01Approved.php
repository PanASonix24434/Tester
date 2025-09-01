<?php

namespace App\Mail\Kru;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Kru01Approved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $data; 
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permohonan Kad Pendaftaran Nelayan dalam Sistem eLesen Perikanan Telah Diluluskan',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.kru.kru01approved',
            with: [
                'ref_no' => $this->data['ref_no'],
                'owner' => $this->data['owner'],
                'vessel' => $this->data['vessel'],
                'kru' => $this->data['kru'],
                'kru_ic' => $this->data['kru_ic'],
                'entity_name' => $this->data['entity_name'],
                'start_date' => $this->data['start_date'],
                'end_date' => $this->data['end_date'],
                'pin_number' => $this->data['pin_number'],
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
