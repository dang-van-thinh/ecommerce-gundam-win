<?php

namespace App\Listeners;

use App\Events\CartReminder;
use App\Mail\CartReminderMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCartReminderEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(CartReminder $event)
    {
        $user = $event->user;

        // Gửi email
        Mail::to($user->email)->send(new CartReminderMail($user));
    }
}
