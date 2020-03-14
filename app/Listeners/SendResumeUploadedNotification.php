<?php

namespace App\Listeners;

use App\Events\ResumeUploaded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendResumeUploadedNotification
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
     * @param  ResumeUploaded  $event
     * @return void
     */
    public function handle(ResumeUploaded $event)
    {
        //$event->user;
    }
}
