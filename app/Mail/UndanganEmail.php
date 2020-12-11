<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UndanganEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $rekrut, $request;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rekrut, $request)
    {
        $this->rekrut = $rekrut;
        $this->request = $request;
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
            'request' => $this->request,
        ];

        return $this->markdown('emails.undangan')
                    ->subject('Undangan Test Magang - MagangHub')
                    ->with('param', $param);
    }
}
