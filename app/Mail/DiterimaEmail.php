<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DiterimaEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $rekrut;
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
            'url' => route('perekrutan.detailpelamar', [
                'id' => $this->rekrut->rekrut_id 
            ]),
            'rekrut' => $this->rekrut,
        ];

        return $this->markdown('emails.diterima')
                    ->subject('Selamat! Anda Diterima - MagangHub')
                    ->with('param', $param);
    }
}
