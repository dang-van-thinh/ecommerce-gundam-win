<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\profiles\EditProfileRequest;
use App\Models\District;
use App\Models\Province;
use App\Models\User;
use App\Models\Ward;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function infomation()
    {
        return view('client.pages.profile.information');
    }


    public function orderHistory()
    {
        return view('client.pages.profile.order');
    }

    public function address()
    {
        $user_id = User::where('user_id')->get();
        $provinces = Province::all();
        $districts = District::where('province_id')->get();
        $wards = Ward::where('district_id')->get();

        return view('client.pages.profile.address', compact('provinces', 'districts', 'wards', 'user_id'));
    }
    public function editProfile(EditProfileRequest $request)
    {
        $id = Auth::user()->id; // Lấy id tài khoản đang đăng nhập
        $user = User::find($id); 
        $data = $request->all(); 
        
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put('users', $request->file('image'));
        }

        $imagePath = $user->image;

        $user->update($data);

        if (
            $request->hasFile('image')
            && !empty($imagePath)
            && Storage::exists($imagePath)
        ) {
            Storage::delete($imagePath);
        }
        toastr("Cập nhật thông tin hồ sơ thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
            "color" => "red"
        ]);
        return back();
    }
}
