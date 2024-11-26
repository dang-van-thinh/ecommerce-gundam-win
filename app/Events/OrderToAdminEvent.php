<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderToAdminEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $noties;

    public function __construct($noties)
    {
//        Log::debug("order created");
        $this->noties = $noties;
    }

    public function broadcastOn()
    {
//        Log::debug("order to admin " . $this->noties);
        return new Channel("order-to-admin");
    }
}
