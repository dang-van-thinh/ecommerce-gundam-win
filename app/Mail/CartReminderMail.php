<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CartReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Nhắc nhở giỏ hàng bỏ quên')
            ->view('client.pages.email.cart_reminder')
            ->with([
                'userName' => $this->user->full_name,
            ]);
    }
}
