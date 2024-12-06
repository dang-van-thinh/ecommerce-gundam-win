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
            $orderId = $request->input("orderId");
            $data = Order::with('orderItems.productVariant.attributeValues.attribute', 'orderItems.productVariant.product')->findOrFail($orderId);
            $ordered = $data->toArray();

            $orderItems = $data->orderItems;
            // dd($orderItems);
            foreach ($orderItems as $key => $orderItem) {
                $quantity = $orderItem->productVariant->quantity;
                // dd($orderItem['product_variant']);
                if ($quantity > 0 && $orderItem->quantity <= $quantity) {
                    Log::info("okee");
                } else {
                    throw new PlaceOrderException('Số lượng sản phẩm trong kho đã thay đổi , vui lòng kiểm tra lại !');
                }
            }
            // dd($ordered);
            // vi la thanh toan online nen phia momo yeu cau la moio giao dich se co order id khac nhau nen ko su dung duoc order id cu nua 
            // nen se tao order id theo cau truc : orderId cu + time()
            $orderIdNew = $ordered["code"] . "-" . time();
            // dd($orderIdNew);
            $dataOrder = [
                "code" => $orderIdNew,
                "total_amount" => (int)$ordered['total_amount']
            ];
            // dd($dataOrder);

            $urlRedirect = route('order-success', $orderId);

            $url = $this->checkOutController->payMomo($dataOrder, $urlRedirect);
            // dd($url);
            if ($url) {
                // Log::debug("Payment");
                return response()->json([
                    "urlRedirect" => $url
                ]);
            } else {
                Log::error("Error Payment checkout continue");
                return response()->json([
                    "message" => "Không thể tiếp tục thanh toán !"
                ], 500);
            }
        } catch (\Throwable $th) {
            if ($th instanceof PlaceOrderException) {
                Log::error($th->getMessage());
                return response()->json([
                    "message" => $th->getMessage()
                ], 500);
            }
            Log::error($th->getMessage());
            return response()->json([
                "message" => $th->getMessage()
            ], 500);
        }
    }
}
