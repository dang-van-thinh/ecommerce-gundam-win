<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\refund\RefundRequest;
use Carbon\Carbon;
use Flasher\Prime\Notification\NotificationInterface;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RefundController extends Controller
{
    public function index()
    {
        $refunds = Refund::with('order.orderItems.productVariant.product', 'refundItem.productVariant.product')
            ->orderBy('id', 'desc')
            ->paginate(12);

        // Tính tổng giá trị hoàn hàng cho từng refund trong trang hiện tại
        $refunds->getCollection()->transform(function ($refund) {
            $refund->refund_total_amount = $refund->refundItem->sum(function ($item) {
                return $item->quantity * $item->productVariant->price;
            });
            return $refund;
        });

        return view('admin.pages.refund.index', compact('refunds'));
    }


    public function update(Request $request, $refundId)
    {
        $refund = Refund::findOrFail($refundId);

        $refundStatus = $request->input('refund_status');
        $refund->update(['status' => $refundStatus]);

        // Lấy dữ liệu trạng thái từ request
        $statuses = $request->input('statuses', []); // Mặc định là mảng rỗng nếu không có

        // Cập nhật từng refundItem dựa trên ID và trạng thái
        foreach ($statuses as $refundItemId => $status) {
            $refundItem = $refund->refundItem()->find($refundItemId);
            if ($refundItem) {
                $refundItem->update(['status' => $status]);
            }
        }
        toastr("Cập nhật thành công !", NotificationInterface::SUCCESS, "Thành công !", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->back();
    }
}
