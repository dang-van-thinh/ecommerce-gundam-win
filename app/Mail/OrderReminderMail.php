<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class OrderReminderMail extends Mailable
{
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->view('client.pages.email.order_reminder')
                    ->with([
                        'userName' => $this->order->user->full_name,
                        'code' => $this->order->code,
                        'orderId' => $this->order->id,
                    ]);
    }
}
