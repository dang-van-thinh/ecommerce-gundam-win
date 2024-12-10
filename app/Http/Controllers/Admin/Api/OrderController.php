<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function filter(Request $request)
    {
        try {
            $rules = [
                'status' => 'required',
                'search' => 'required'
            ];
            $message = [
                'status.required' => 'Không được để trống trường trạng thái !',
                'search.required' => 'Không được để trống từ khóa !'
            ];

            $request->validate($rules, $message);
            $status = $request->status;
            $search = $request->search;

            $query = Order::with('user')->latest('id');

            // Áp dụng bộ lọc trạng thái nếu có
            if ($status !== 'all') {
                $query->where('status', $status);
            }

            // Áp dụng tìm kiếm nếu có
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('full_name', 'like', '%' . $search . '%');
                        });
                });
            }

            $orders = $query->paginate(12);

            return response()->json([
                'orders' => $orders,
                'pagination' => [
                    'prev_page_url' => $orders->previousPageUrl(),
                    'next_page_url' => $orders->nextPageUrl(),
                    'current_page' => $orders->currentPage(),
                    'last_page' => $orders->lastPage(),
                ]
            ]);
        } catch (\Exception $e) {
            if ($e instanceof ValidationException) {
                return response()->json([
                    'message' => $e->errors()
                ], status: 400);
            }
            return response()->json([
                'error' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
