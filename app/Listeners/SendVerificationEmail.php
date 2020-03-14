<?php

namespace App\Listeners;

use App\Events\VerificationEmail;
use App\Mail\ConfirmEmail;
use App\Mail\ForgetPasswordMail;
use App\Notifications\ConfirmMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  VerificationEmail  $event
     * @return void
     */
    public function handle(VerificationEmail $event)
    {
        Mail::send(new ConfirmEmail($event->data));
    }
}
