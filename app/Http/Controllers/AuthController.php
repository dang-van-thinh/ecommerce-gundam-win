<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\VerifyAccount;
use App\Models\User;
use Auth;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;
use Mail;
class AuthController extends Controller
{
    public function loginView()
    {
        return view('client.pages.auth.login');
    }
    public function storeLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            toastr("Xin chào bạn đến với GunDamWin", NotificationInterface::SUCCESS, "Đăng nhập tài khoản thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return redirect()->route('home');
        }

        toastr("Thông tin tài khoản mật khẩu không chính xác", NotificationInterface::ERROR, "Đăng nhập thất bại", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return back();
    }
    public function registerView()
    {
        return view('client.pages.auth.register');
    }
    public function storeRegister(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        // Tạo người dùng mới
        $user = User::create([
            'full_name' => $validatedData['full_name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'status' => 'ACTIVE',
            'image' => $validatedData['image'] ?? null,
            'phone' => $validatedData['phone'],
        ]);
        // Gán vai trò cho người dùng (nếu cần)
        $user->roles()->sync([1]);

        Mail::to($user->email)->send(new VerifyAccount($user));

        // Đăng nhập người dùng
        Auth::login($user);

        // Thông báo thành công
        toastr("Vui lòng kiểm tra email để xác thực tài khoản", NotificationInterface::SUCCESS, "Đăng ký tài khoản thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);

        // Chuyển hướng đến trang chủ
        return redirect()->route('home');
    }
    public function verify($email)
    {
        $acc = User::where('email', $email)->first();
        // Kiểm tra xem tài khoản đã được xác thực hay chưa
        if ($acc && !$acc->email_verified_at) {
            User::where('email', $email)->update(['email_verified_at' => now()]);
            // Thông báo xác thực thành công
            toastr("Tài khoản của bạn đã được xác thực thành công! <br> Chào mừng bạn đến với shop", NotificationInterface::SUCCESS, "Xác thực tài khoản thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        } elseif ($acc && $acc->email_verified_at) {
            // Thông báo lỗi nếu tài khoản đã được xác thực
            toastr("Tài khoản của bạn đã được xác thực trước đó.", NotificationInterface::ERROR, "Xác thực tài khoản", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        } else {
            // Thông báo lỗi nếu không tìm thấy tài khoản
            toastr("Tài khoản không tồn tại.", NotificationInterface::ERROR, "Xác thực tài khoản", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        }

        return redirect()->route('home');
    }
    public function fogetPasswordView()
    {
        return view('client.pages.auth.foget-password');
    }
}
