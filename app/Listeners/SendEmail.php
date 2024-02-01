<?php

namespace App\Listeners;

use App\Events\OrderEmail;
use App\Mail\MailNotify;
use Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderEmail $event): void
    {
        $data = [
            'subject' => 'crm email',
            'body' => 'your order registerd'
        ];
        Mail::to(auth()->user()->email)->send(new MailNotify($data));
    }
}
