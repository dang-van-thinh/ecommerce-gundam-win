<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addToCart(Request $request)
    {
        $userId = $request->input('userId');
        $quantity = $request->input('quantity');
        $variantId = $request->input('variantId');

        // tao moi data them moi
        $cart = [
            'user_id' => $userId,
            'product_variant_id' => $variantId,
            'quantity' => $quantity
        ];

        // check trung
        $carted = Cart::query()->where('user_id', $userId)->where([
            ['user_id', '=', $userId],
            ['product_variant_id', '=', $variantId]
        ])->first();
        // dd($carted->toArray());


        if ($carted) {
            $quantityNew = $carted->quantity + $quantity;
            // dd($quantity);
            $carted->update(['quantity' => $quantityNew]);
        } else {
            Cart::query()->create($cart);
        }

        $cartResponse = Cart::where('user_id', $userId)->count('*');
        return response()->json([
            'message' => [
                'numberCart' => $cartResponse
            ]
        ]);
    }

    public function deleteToCart(Request $request)
    {
        $variantId = $request->input('variantId');
        $userId = $request->input('userId');
        if (Cart::query()->findOrFail($variantId)->delete()) {
            $cartResponse = Cart::where('user_id', $userId)->count('*');
            return response()->json([
                'message' => [
                    'status' => "Xóa thành công",
                    'numberCart' => $cartResponse
                ]
            ]);
        }
        return response()->json([
            'message' => "Xóa thành công"
        ], 400);
    }
}
