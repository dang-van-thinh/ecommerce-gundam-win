<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index($id)
    {
        $data = Order::with('orderItems.productVariant.attributeValues.attribute')->findOrFail($id);

        // dd($data->toArray());
        return view('client.pages.order-success.index', compact('data'));
    }
}
