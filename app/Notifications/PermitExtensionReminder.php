<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PermitExtensionReminder extends Notification
{
    use Queueable;

    protected $permit;
    protected $reminder;

    protected $permit;
    protected $reminder;

    public function __construct($permit, $reminder)
    {
        $this->permit = $permit;
        $this->reminder = $reminder;
    public function __construct($permit, $reminder)

        $this->permit = $permit;
        $this->reminder = $reminder;ry channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $permit = $this->permit;
        
                    ->subject('Peringatan: Permohonan Lanjutan Tempoh Sah Kelulusan Perolehan')
                    ->greeting('Assalamualaikum dan Salam Sejahtera,')
                    ->line('Dengan hormatnya dimaklumkan bahawa permit perikanan anda memerlukan perhatian.')
                    ->line('**Maklumat Permit:**')
                    ->line('• No. Permit: ' . $permit->no_permit)
                    ->line('• No. Permit: ' . ($permit->no_permit ?? 'N/A'))
                    ->line('• Jenis Peralatan: ' . ($permit->jenis_peralatan ?? 'N/A'))
                    ->line('• Tarikh Luput: ' . ($permit->expiry_date ? $permit->expiry_date->format('d/m/Y') : 'N/A'))
                    ->line('• Kali Permohonan: ' . ($permit->getApplicationCountText() ?? 'Kali Pertama'))
                    ->line('Permit anda telah dilanjutkan tempoh selama 3 bulan dan kini memerlukan tindakan lanjutan.')
                    ->line('Sila buat permohonan lanjutan tempoh yang baru untuk mengelakkan permit luput.')
                    ->action('Buat Permohonan Lanjutan Tempoh', url('/application/borang-permohonan'))
                    ->line('')
                    ->line('Sekiranya anda memerlukan bantuan, sila hubungi pihak kami.')
                    ->salutation('Terima kasih.');kan bantuan, sila hubungi pihak kami.')
                    ->salutation('Terima kasih.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
