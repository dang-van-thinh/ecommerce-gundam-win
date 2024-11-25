<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ChatMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn(): PrivateChannel
    {
        Log::debug("chat realtime phong " . $this->message->receiver_id);
        if ($this->message->receiver_id == null) {
            return new PrivateChannel('chat.' . $this->message->sender_id);
        }
        return new PrivateChannel('chat.' . $this->message->receiver_id);
    }
}
