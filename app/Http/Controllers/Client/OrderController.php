<?php

namespace App\Http\Controllers\Client;

use App\Exceptions\Order\PlaceOrderException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request, $id)
    {
        try {
                $data = Order::with('orderItems.productVariant.attributeValues.attribute', 'orderItems.productVariant.product')->findOrFail($id);
                return view('client.pages.order-success.index', compact('data'));
        } catch (\Throwable $th) {
            if ($th instanceof PlaceOrderException) {
                sweetalert($th->getMessage(), NotificationInterface::ERROR, [
                    'position' => "center",
                    'timeOut' => '',
                    'closeButton' => false
                ]);
                return redirect()->route("profile.order-history");
            }
        }
    }
}
