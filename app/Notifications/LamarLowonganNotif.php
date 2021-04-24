<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LamarLowonganNotif extends Notification
{
    use Queueable;

    protected $lowongan_judul;
    protected $univ_nama;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($lowongan_judul, $univ_nama)
    {
        $this->lowongan_judul = $lowongan_judul;
        $this->univ_nama = $univ_nama;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'text' => 'Lamaran baru dari <b>'.$this->univ_nama.'</b> pada lowongan '.$this->lowongan_judul,
            'url' => route('perekrutan.pelamar').'?filter_status=melamar',
        ];
    }
}
