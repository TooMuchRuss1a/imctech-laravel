<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Mail\Events\MessageSending;

class LogSendingMessage
{
    public function handle(MessageSending $event)
    {
        $message = $event->message;

        info('[EMAIL] SENDING: ' . $message->getFrom()[0]->getAddress() . ' > ' . $message->getTo()[0]->getAddress() . ' - ' . $message->getSubject());
    }
}
