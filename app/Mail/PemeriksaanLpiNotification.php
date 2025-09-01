<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PemeriksaanLpiNotification extends Mailable
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
        return $this->subject('Notifikasi Pemeriksaan Vesel')
            ->view('emails.pemeriksaan_lpi')
            ->with('resultDetails', $this->resultDetails);
    }
}
 