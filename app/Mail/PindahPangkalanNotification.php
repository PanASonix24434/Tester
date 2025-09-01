<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PindahPangkalanNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $resultDetails;
    public $pangkalan;

    /**
     * Create a new message instance.
     *
     * @param array $resultDetails
     */
    public function __construct($resultDetails, $pangkalan)
    {
        $this->resultDetails = $resultDetails;
        $this->pangkalan = $pangkalan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notifikasi Pindah Pangkalan')
            ->view('emails.pindah_pangkalan')
            ->with([
                'resultDetails'  => $this->resultDetails,
                'pangkalan'  => $this->pangkalan,
            ]);
    }
}
