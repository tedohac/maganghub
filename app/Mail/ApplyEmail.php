<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $lowongan, $mahasiswa;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($lowongan, $mahasiswa)
    {
        $this->lowongan = $lowongan;
        $this->mahasiswa = $mahasiswa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $param = [
            'url' => route('perekrutan.pelamar'),
            'lowongan' => $this->lowongan,
            'mahasiswa' => $this->mahasiswa,
        ];

        return $this->markdown('emails.apply')
                    ->subject('Lamaran Magang Baru - MagangHub')
                    ->with('param', $param);
    }
}
