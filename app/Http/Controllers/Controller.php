<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    // ví dụ sử dụng toast cho các bạn nhé 
    public function test()
    {
        // toastr()->error('Hiển thị thông báo lỗi nè .', "Thông tin đăng nhập"); // notification

        return back()->with('success', 'Hiển thị thông báo thành công nè !'); // flash session
        // return back();
    }
}
