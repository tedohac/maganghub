<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TolakUndanganEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $rekrut, $alasan_penolakan;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rekrut, $alasan_penolakan)
    {
        $this->rekrut = $rekrut;
        $this->alasan_penolakan = $alasan_penolakan;
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
            'alasan_penolakan' => $this->alasan_penolakan,
        ];

        return $this->markdown('emails.tolakundangan')
                    ->subject('Undangan Test Ditolak - MagangHub')
                    ->with('param', $param);
    }
}
