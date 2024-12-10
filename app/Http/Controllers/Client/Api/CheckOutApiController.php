<?php

namespace App\Http\Controllers\Client\Api;

use App\Exceptions\Order\PlaceOrderException;
use App\Http\Controllers\Client\CheckOutController;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckOutApiController extends Controller
{
    public $checkOutController;
    public function __construct(CheckOutController $checkOutController)
    {
        $this->checkOutController = $checkOutController;
    }
    public function continueCheckOut(Request $request)
    {
        try {
            // Validate dữ liệu đầu vào
            $validated = $request->validate([
                'orderId' => 'required|integer|exists:orders,id',
            ], [
                'orderId.required' => 'Id đơn hàng là bắt buộc.',
                'orderId.integer' => 'Id đơn hàng phải là một số nguyên.',
                'orderId.exists' => 'Đơn hàng không tồn tại.',
            ]);

            // Lấy thông tin đơn hàng từ ID
            $orderId = $validated['orderId'];
            $data = Order::with('orderItems.productVariant.attributeValues.attribute', 'orderItems.productVariant.product')->findOrFail($orderId);

            // Kiểm tra số lượng sản phẩm
            foreach ($data->orderItems as $orderItem) {
                $quantity = $orderItem->productVariant->quantity;
                if ($quantity <= 0 || $orderItem->quantity > $quantity) {
                    throw new PlaceOrderException('Số lượng sản phẩm trong kho đã thay đổi, vui lòng kiểm tra lại!');
                }
            }

            // Tạo mã đơn hàng mới và xử lý thanh toán
            $orderIdNew = $data->code . "-" . time();
            $dataOrder = [
                "code" => $orderIdNew,
                "total_amount" => (int)$data->total_amount
            ];
            $urlRedirect = route('order-success', $orderId);
            $url = $this->checkOutController->payMomo($dataOrder, $urlRedirect);

            if ($url) {
                return response()->json([
                    "urlRedirect" => $url
                ]);
            } else {
                return response()->json([
                    "message" => "Không thể tiếp tục thanh toán!"
                ], 500);
            }
        } catch (\Throwable $th) {
            if ($th instanceof PlaceOrderException) {
                return response()->json([
                    "message" => $th->getMessage()
                ], 500);
            }

            return response()->json([
                "message" => $th->getMessage()
            ], 500);
        }
    }

}
