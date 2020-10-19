<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgetpassEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $email, $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $param = [
            'url' => route('resetpass', [
                'email' => $this->email,
                'token' => $this->token 
            ]),
            'email' => $this->email,
        ];
        
        return $this->markdown('emails.forgetpass')
                    ->subject('Reset Password - MagangHub')
                    ->with('param', $param);
    }
}
