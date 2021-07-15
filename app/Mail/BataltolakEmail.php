<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BataltolakEmail extends Mailable
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

        return $this->markdown('emails.bataltolak')
                    ->subject('Lamaran Magang Batal Ditolak - MagangHub')
                    ->with('param', $param);
    }
}
