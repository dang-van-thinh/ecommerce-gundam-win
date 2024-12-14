<?php

namespace App\Http\Controllers\Admin;

use Flasher\Prime\Notification\NotificationInterface;
use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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

    public function edit(string $id)
    {
        $refund = Refund::findOrFail($id);
        return view('admin.pages.refund.edit', compact('refund'));
    }

    public function update(Request $request, $refundId)
    {
        try {
            $refund = Refund::findOrFail($refundId);

            // Validate dữ liệu đầu vào
            $validatedData = $request->validate([
                'refund_status' => ['required', Rule::in(['PENDING', 'APPROVED', 'IN_TRANSIT', 'COMPLETED'])],
                'statuses' => ['nullable', 'array'], // Mảng hoặc null
                'statuses.*' => ['required', Rule::in(['PENDING', 'APPROVED', 'REJECTED'])], // Các giá trị enum hợp lệ
            ]);

            // Cập nhật trạng thái chính của Refund
            $refund->update(['status' => $validatedData['refund_status']]);

            // Cập nhật trạng thái các RefundItem
            if (!empty($validatedData['statuses'])) {
                foreach ($validatedData['statuses'] as $refundItemId => $status) {
                    $refundItem = $refund->refundItem()->find($refundItemId);

                    // Kiểm tra RefundItem có tồn tại
                    if (!$refundItem) {
                        throw new \Exception("Sản phẩm hoàn trả với ID {$refundItemId} không tồn tại.");
                    }

                    // Cập nhật trạng thái RefundItem
                    $refundItem->update(['status' => $status]);
                }
            }

            // Thông báo thành công
            toastr("Cập nhật trạng thái thành công!", NotificationInterface::SUCCESS, "Thành công!", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);

            return redirect()->back();
        } catch (ValidationException $e) {
            // Xử lý lỗi validation
            toastr("Dữ liệu không hợp lệ, vui lòng kiểm tra lại!", NotificationInterface::ERROR, "Lỗi!", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);

            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            // Xử lý các lỗi khác
            toastr($e->getMessage(), NotificationInterface::ERROR, "Lỗi!", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);

            return redirect()->back();
        }
    }
}
