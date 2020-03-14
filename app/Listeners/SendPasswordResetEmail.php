<?php

namespace App\Listeners;

use App\Events\PasswordResetSuccess;
use App\Mail\ForgetPasswordMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetEmail
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
     * @param  PasswordResetSuccess  $event
     * @return void
     */
    public function handle(PasswordResetSuccess $event)
    {
        Mail::send(new ForgetPasswordMail($event->data));
    }
}
