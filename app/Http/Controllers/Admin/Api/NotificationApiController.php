<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationApiController extends Controller
{
    public function updateReadNotification(Request $request)
    {
        Notification::findOrFail($request->id)->update(["read_at" => now()]);
        dd($request->all());
        return response()->json(["success" => true]);
    }


    public function notifications()
    {
        $noties = Notification::where("type", "ADMIN");
        $countNoties = $noties->count();
        $allNoties = $noties->get()->toArray();
        // dd($countNoties, $allNoties);
        return response()->json([
            "allNoties" => $allNoties,
            "countNoties" => $countNoties
        ]);
    }
}
