<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AccountApprovedNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Akun Anda Sudah Aktif')
            ->greeting('Assalamu’alaikum ' . $notifiable->name)
            ->line('Akun Anda telah disetujui oleh administrator.')
            ->line('Sekarang Anda sudah dapat login dan menggunakan aplikasi.')
            ->action('Login Sekarang', url('/login'))
            ->line('Terima kasih.');
    }
}
