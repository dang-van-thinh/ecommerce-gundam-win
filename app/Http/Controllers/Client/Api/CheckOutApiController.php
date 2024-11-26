<?php

namespace App\Http\Controllers\Client\Api;

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
        $orderId = $request->input("orderId");
        $ordered = Order::findOrFail($orderId)->toArray();
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
    }
}
