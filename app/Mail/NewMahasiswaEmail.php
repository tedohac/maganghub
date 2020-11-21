<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMahasiswaEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $request, $univ_nama, $prodi_nama, $user_verify_token, $passwordTemp;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request, $univ_nama, $prodi_nama, $user_verify_token, $passwordTemp)
    {
        $this->request = $request;
        $this->univ_nama = $univ_nama;
        $this->prodi_nama = $prodi_nama;
        $this->user_verify_token = $user_verify_token;
        $this->passwordTemp = $passwordTemp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $param = [
            'url' => route('verify', [
                'email' => strtolower($this->request->mahasiswa_user_email),
                'token' => $this->user_verify_token 
            ]),
            'request' => $this->request,
            'univ_nama' => $this->univ_nama,
            'prodi_nama' => $this->prodi_nama,
            'password' => $this->passwordTemp,
        ];

        return $this->markdown('emails.newmahasiswa')
                    ->subject('Akun Mahasiswa - MagangHub')
                    ->with('param', $param);
    }
}
