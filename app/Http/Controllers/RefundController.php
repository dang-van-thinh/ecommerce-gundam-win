<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\refund\RefundRequest;
use Carbon\Carbon;
use Flasher\Prime\Notification\NotificationInterface;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index()
    {
        $refund = Refund::with('order')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.pages.refund.index', ['listRefund' => $refund]);
    }

    public function create()
    {
        // $orders = Order::all();
        return view('admin.pages.refund.create');
    }
    public function store(RefundRequest $request)
    {
        // Kiểm tra đơn hàng
        $order = Order::where('code', $request->order_code)->first();
        $refund = Refund::where('order_id', $order->id)->first();
        if ($order->status !== 'COMPLETED' || $order->confirm_status !== 'ACTIVE' || Carbon::parse($order->updated_at)->lt(Carbon::now()->subDays(3))) {
            // Nếu không thỏa mãn điều kiện, không cho phép tạo đơn hoàn hàng
            toastr("Chỉ có thể tạo đơn hoàn hàng khi đơn hàng đã hoàn thành và trong vòng 3 ngày kể từ khi cập nhật.", NotificationInterface::ERROR, "Lỗi");
            return back();
        }
        if ($refund) {
            toastr("Mỗi đơn hàng chỉ có thể tạo 1 đơn hoàn hàng.", NotificationInterface::ERROR, "Lỗi");
            return back();
        }
        // Xử lý ảnh (nếu có)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('refund_images', 'public');
        }

        // Tạo hoàn hàng
        Refund::create([
            'order_id' => $order->id,
            'reason' => $request->reason,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => 'ORDER_CREATED',
        ]);
        // Cập nhật trạng thái đơn hàng
        $order->status = 'REFUND';
        $order->save();
        toastr("Tạo đơn hoàn hàng thành công.", NotificationInterface::SUCCESS, "Thành công");
        return redirect()->route('refund.index');
    }
    public function edit(string $id)
    {
        $refund = Refund::findOrFail($id);
        $orders = Order::all();
        return view("admin.pages.refund.update", compact('refund', 'orders'));
    }
    public function update(Request $request, $id)
    {
        $refund = Refund::findOrFail($id);

        // Kiểm tra nếu nút Hủy đơn hoàn được nhấn
        if ($request->has('cancel_refund') && $request->cancel_refund == 'true') {
            $refund->status = 'CANCEL_REFUND_ORDER';  // Hủy đơn hoàn
            $refund->save();
            toastr("Trạng thái hoàn hàng đã được cập nhật.", NotificationInterface::WARNING, "Thành công");
            return back();
        }

        // Cập nhật trạng thái nếu không hủy
        if ($request->has('status')) {
            // Cập nhật trạng thái hoàn hàng
            $refund->status = $request->status;
            $refund->save();
            toastr("Trạng thái hoàn hàng đã được cập nhật.", NotificationInterface::SUCCESS, "Thành công");
            return back();
        }

        return back()->with('error', 'Không có thay đổi nào được thực hiện.');
    }
}
