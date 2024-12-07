<?php

namespace App\Listeners;

use App\Events\CartReminder;
use App\Events\ForgotPasswordEvent;
use App\Events\OrderReminder;
use App\Events\OrderSuccessEvent;
use App\Events\VerifyEmailEvent;
use App\Mail\CartReminderMail;
use App\Mail\FogotPass;
use App\Mail\OrderCompletedMail;
use App\Mail\OrderReminderMail;
use App\Mail\VerifyAccount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailListener implements ShouldQueue
{

    public function handleVerifyEmail(VerifyEmailEvent $event):void {
        Log::info($event->user);
        Mail::to($event->user)->send(new VerifyAccount($event->user));
    }

    public function handleForgotPassword(ForgotPasswordEvent $event):void {
        Log::info(__CLASS__.__FUNCTION__.$event->user . $event->newPassword);
        Mail::to($event->user->email)->send(new FogotPass($event->user, $event->newPassword));
    }

    public function handleOrderSuccess(OrderSuccessEvent $event):void {
        Log::info(__CLASS__ . __FUNCTION__ . $event->user->email);
        Mail::to($event->user->email)->send(new OrderCompletedMail($event->order));
    }
    public function handleCartReminderEmail(CartReminder $event)
    {
        $user = $event->user;
        // Gửi email
        Mail::to($user->email)->send(new CartReminderMail($user));
    }
    public function handleOrderReminderEmail(OrderReminder $event)
    {
        $order = $event->order;
        // Gửi email nhắc nhở
        Mail::to($order->user->email)->send(new OrderReminderMail($order));
    }
    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            VerifyEmailEvent::class => 'handleVerifyEmail',
            ForgotPasswordEvent::class => 'handleForgotPassword',
            OrderSuccessEvent::class => 'handleOrderSuccess',
            OrderReminder::class => 'handleOrderReminderEmail',
            CartReminder::class => 'handleCartReminderEmail',
        ];
    }
}
