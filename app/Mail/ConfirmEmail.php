<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    const VERIFY_EMAIL_URL = '/verify-registration-email';
    const REDIRECT_EMAIL_URL = '/login';

    public $verify_email_link;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void/
     */
    public function __construct($data)
    {
      //  $this->setVerifyEmailLink($data['url']);
      //  $this->data = (object) $data;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build():self
    {

        $this->setVerifyEmailLink($this->data);
        return $this->view('emails.confirmMail')
            ->to($this->data['user']['email'])
            ->with([
                'email' => $this->data['user']['email'],
                'email_link' => $this->verify_email_link
            ]);
    }

    protected function setVerifyEmailLink($url)
    {
        $this->verify_email_link = $url;

         $this->verify_email_link = rtrim(config('app.app_url'), '/') . static::VERIFY_EMAIL_URL . "?token={$this->data['user']['email_token']}";
    }
}
