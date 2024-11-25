<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use App\Events\TestNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Str;
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

    public function testNotification()
    {

        broadcast(new TestEvent("oke ae nhes"));
        Log::info("controller test ");
        return view("admin.test");
    }

    //    public function test()
    //    {
    //
    //        // Tạo một chuỗi ngẫu nhiên gồm các chữ cái viết hoa và số với độ dài 8 ký tự
    //        $code = Str::upper(Str::random(8));
    //
    //        // Đảm bảo chuỗi có cả số và chữ cái bằng cách trộn ký tự từ hai tập hợp riêng biệt
    //        $letters = Str::random(4); // Lấy 4 chữ cái ngẫu nhiên
    //        $numbers = substr(str_shuffle("0123456789"), 0, 4); // Lấy 4 số ngẫu nhiên
    //
    //        // Gộp và xáo trộn chữ cái và số để đảm bảo vị trí ngẫu nhiên
    //        $mixedCode = str_shuffle($letters . $numbers);
    //
    //        dd(strtoupper($mixedCode));
    //        // sweetalert("Bạn đã cài thành công rồi nhé !", NotificationInterface::INFO, [
    //        //     'position' => "center",
    //        //     'timeOut' => '',
    //        //     'closeButton' => false
    //        // ]);
    //
    //        // sweetalert()->addImage("ảnh nè", 'Oke luôn chứ nị', '/template/images/admin.jpg');
    //
    //        toastr("Wow bạn đỉnh thực sự , chạy thành công rồi nhé !", NotificationInterface::SUCCESS, "Thân gửi các AE trong nhóm", [
    //            "closeButton" => true,
    //            "progressBar" => true,
    //            "timeOut" => "3000",
    //            "color" => "red"
    //        ]);
    //
    //        return view("admin.test");
    //    }
}
