<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BroadcastLowonganNotif extends Notification
{
    use Queueable;

    protected $lowongan_id;
    protected $lowongan_judul;
    protected $perusahaan_nama;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($lowongan_id, $lowongan_judul, $perusahaan_nama)
    {
        $this->lowongan_id = $lowongan_id;
        $this->lowongan_judul = $lowongan_judul;
        $this->perusahaan_nama = $perusahaan_nama;
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
            'text' => '<b>'.$this->perusahaan_nama.'</b> mengundan anda untuk melamar pada lowongan '.$this->lowongan_judul,
            'url' => route('lowongan.detail', [
                'id' => $this->lowongan_id 
            ]),
            'lowongan_id' => $this->lowongan_id,
        ];
    }
}
