<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationApiController extends Controller
{
    public function updateReadNotification(Request $request)
    {
        Notification::findOrFail($request->input("id"))->update(["read_at" => now()]);
        //        dd($request->all());
        return response()->json(["success" => true]);
    }

    public function notifications()
    {
        $noties = Notification::where("type", "ADMIN")->get()->toArray();
        $countNoties = Notification::where("type", "ADMIN")
            ->whereNull("read_at") // hoặc `where("is_read", false)` nếu bạn sử dụng cột `is_read`
            ->count();
        // dd($countNoties, $allNoties);
        return response()->json([
            "allNoties" => $noties,
            "countNoties" => $countNoties
        ]);
    }
}
