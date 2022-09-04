<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Mail\Events\MessageSent;

class LogSentMessage
{
    public function handle(MessageSent $event)
    {
        $message = $event->message;

        info('[EMAIL] SENT: ' . $message->getFrom()[0]->getAddress() . ' > ' . $message->getTo()[0]->getAddress() . ' - ' . $message->getSubject());
    }
}
