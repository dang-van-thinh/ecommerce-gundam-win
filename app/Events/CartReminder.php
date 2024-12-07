<?php
    namespace App\Events;

    use Illuminate\Broadcasting\InteractsWithSockets;
    use Illuminate\Foundation\Events\Dispatchable;
    use Illuminate\Queue\SerializesModels;

    class CartReminder
    {
        use Dispatchable, InteractsWithSockets, SerializesModels;

        public $user;

        public function __construct($user)
        {
            $this->user = $user;
        }
    }

