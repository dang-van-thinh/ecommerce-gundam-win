<?php

namespace App\Listeners;

use App\Events\OrderReminder;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReminderMail;

class SendOrderReminderEmail
{
    public function handle(OrderReminder $event)
    {
        $order = $event->order;

        // Gửi email nhắc nhở
        Mail::to($order->user->email)->send(new OrderReminderMail($order));
    }
}
