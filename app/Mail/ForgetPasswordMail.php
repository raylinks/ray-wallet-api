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

    public const RESET_PASSWORD_URL = '/reset-password';
    public $reset_password_link;
    public $user;
    public $data;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param $token
     * @param string|null $redirect_url
     */
    //public function __construct($user, string $passwordReset ,string $redirect_url = null)
    public function __construct(array $data)
    {
        $this->data = $data;

//        $this->setResetPasswordLink( $redirect_url);
//        $this->user = $user;
//        $this->tok = $passwordReset;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build():self
    {
        $this->setResetPasswordLink($this->data);
        return $this->subject('Reset Your Password')
            ->to($this->data['user']->email)
            ->with([
                'passwordResetLink' => $this->reset_password_link,
            ])
            ->view('emails.resetPassword');
    }

    private function setResetPasswordLink(array $data):void
    {
       // dd($data);
        $redirect_url =  rtrim(config('app.app_url'), '/') . static::RESET_PASSWORD_URL;
        $this->reset_password_link = $redirect_url . "%s?token={$data['token']->token}";
    }
}
