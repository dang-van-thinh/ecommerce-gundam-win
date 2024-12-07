<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Events\OrderReminder;
use Carbon\Carbon;

class CheckUnpaidOrders extends Command
{
    protected $signature = 'orders:check-unpaid';
    protected $description = 'Gửi email nhắc nhở các đơn hàng chưa thanh toán';

    public function handle()
    {
        $orders = Order::where('status', 'PROCESSING')
                       ->where('created_at', '<', Carbon::now()->subDays(3))
                       ->get();

        foreach ($orders as $order) {
            event(new OrderReminder($order));
        }

        $this->info('Đã gửi nhắc nhở cho các đơn hàng chưa thanh toán.');
    }
}
