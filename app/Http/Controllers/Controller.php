<?php

namespace App\Http\Controllers;

use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Yoeunes\Toastr\Facades\Toastr;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    // ví dụ sử dụng toast cho các bạn nhé
    public function notification()
    {
        // toastr()->error('Hiển thị thông báo lỗi nè .', "Thông tin đăng nhập"); // notification

        return back()->with('success', 'Hiển thị thông báo thành công nè !'); // flash session
        // return back();
    }

    public function test()
    {
        sweetalert("Bạn đã cài thành công rồi nhé !", NotificationInterface::INFO, [
            'position' => "center",
            'timeOut' => '',
            'closeButton' => false
        ]);

        sweetalert()->addImage("ảnh nè", 'Oke luôn chứ nị', '/template/images/admin.jpg');

        toastr("Wow bạn đỉnh thực sự , chạy thành công rồi nhé !", NotificationInterface::SUCCESS, "Thân gửi các AE trong nhóm", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
            "color" => "red"
        ]);

        return view("admin.test");
    }
}
