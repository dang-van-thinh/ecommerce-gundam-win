<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Throw_;

class UserController extends Controller
{
    // App\Http\Controllers\Admin\Api\UserController.php

    public function filter(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        try {
            $query = User::with('roles')->latest('id');  // Sử dụng 'roles' thay vì 'role'

            // Tìm kiếm theo tên hoặc email
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('email', 'LIKE', '%' . $search . '%');
                });
            }

            // Lọc theo trạng thái
            if ($status && $status !== 'all') {
                $query->where('status', $status);
            }

            // Phân trang
            $users = $query->paginate(12);

            return response()->json([
                'users' => $users,
                'pagination' => [
                    'prev_page_url' => $users->previousPageUrl(),
                    'next_page_url' => $users->nextPageUrl(),
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                ],
                'message' => 'Không tìm thấy tài khoản.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function changeStatus(User $user)
    {
        try {
            // Chuyển trạng thái người dùng
            $newStatus = $user->status === 'ACTIVE' ? 'IN_ACTIVE' : 'ACTIVE';
            $user->status = $newStatus;
            $user->save();

            return response()->json([
                'message' => 'Trạng thái người dùng đã được cập nhật.',
                'status' => $newStatus,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }

    // danh sach user kenh chat
    public function getAllUser(Request $request)
    {
        $userId = $request->input("userId");
        //        dd($userId);
        $users = User::whereNotIn('id', [$userId])->get();
        return response()->json([
            "users" => $users,
            "userId" => $userId
        ]);
    }

    public function searchUserChat(Request $request)
    {
        $search = $request->search;
        $userId = $request->userId;

        try {
            $query = User::query()->whereNotIn('id', [$userId]);

            // Tìm kiếm theo tên hoặc email
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('email', 'LIKE', '%' . $search . '%');
                });
            }
            // Phân trang
            $users = $query->get();
            return response()->json([
                'users' => $users
            ]);
        } catch (\Throwable $exception) {

        }
    }
}
