<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;

class ForgetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public const RESET_PASSWORD_URL = '/resetpassword';
    public $reset_password_link;
    public $user;
    public $tok;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param $token
     * @param string|null $redirect_url
     */
    public function __construct($user, string $passwordReset ,string $redirect_url = null)
    {
        $this->setResetPasswordLink( $redirect_url);
        $this->user = $user;
        $this->tok = $passwordReset;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reset Your Password')
            ->to($this->user->email)
            ->view('emails.confirmMail');
    }

    private function setResetPasswordLink( string $redirect_url = null)
    {
        $redirect_url = $redirect_url ?: rtrim(config('app.url'), '/') . static::RESET_PASSWORD_URL;
        $this->reset_password_link = $redirect_url . "?token={token}";
    }
}
