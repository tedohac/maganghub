<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TolakEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $lowongan;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rekrut)
    {
        $this->rekrut = $rekrut;
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
            'url' => route('perekrutan.detaillamaran', [
                'id' => $this->rekrut->rekrut_id 
            ]),
            'rekrut' => $this->rekrut
        ];

        return $this->markdown('emails.apply')
                    ->subject('Lamaran Magang Ditolak - MagangHub')
                    ->with('param', $param);
    }
}
