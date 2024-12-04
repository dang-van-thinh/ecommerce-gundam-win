<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cart;
use App\Events\CartReminder;
use Carbon\Carbon;

class CheckAbandonedCarts extends Command
{
    protected $signature = 'cart:check-abandoned';
    protected $description = 'Kiểm tra và gửi email nhắc nhở giỏ hàng bỏ quên';

    public function handle()
    {
        $abandonedCarts = Cart::where('updated_at', '<', Carbon::now()->subDays(3))
            ->get();

        foreach ($abandonedCarts as $cart) {
            if ($cart->user) {
                event(new CartReminder($cart->user));
            }
        }

        $this->info('Nhắc nhở giỏ hàng bỏ quên đã được xử lý.');
    }
}
