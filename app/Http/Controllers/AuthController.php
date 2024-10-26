<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\FogetPassRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ChangePassRequest;
use App\Mail\FogotPass;
use App\Mail\VerifyAccount;
use App\Models\User;
use Auth;
use Cookie;
use Flasher\Prime\Notification\NotificationInterface;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Str;
class AuthController extends Controller
{
    public function loginView()
    {
        // Trả về trang đăng nhập từ view 'client.pages.auth.login'
        return view('client.pages.auth.login');
    }
    public function storeLogin(LoginRequest $request)
    {
        // Lấy thông tin 'email' và 'password' từ request
        $credentials = $request->only('email', 'password');
        // Tìm người dùng có email tương ứng
        $user = User::where('email', $credentials['email'])->first();
        // Kiểm tra xem tài khoản có tồn tại không
        if (!$user) {
            // Thông báo tài khoản không tồn tại
            toastr("Tài khoản không tồn tại", NotificationInterface::ERROR, "Đăng nhập thất bại", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return back(); // Quay lại trang trước
        }
        // Kiểm tra trạng thái tài khoản (tài khoản có bị khóa không)
        if ($user->status !== 'ACTIVE') {
            // Thông báo tài khoản bị khóa
            toastr("Tài khoản của bạn đã bị khóa <br> Vui lòng liên hệ shop", NotificationInterface::ERROR, "Đăng nhập thất bại", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return back(); // Quay lại trang trước
        }
        // Kiểm tra xem tài khoản đã được xác thực email chưa
        if (is_null($user->email_verified_at)) {
            // Thông báo tài khoản chưa xác thực email
            toastr("Tài khoản của bạn chưa được xác thực email", NotificationInterface::ERROR, "Đăng nhập thất bại", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return back(); // Quay lại trang trước
        }
        // Thực hiện đăng nhập người dùng nếu thông tin đăng nhập đúng
        if (Auth::attempt($credentials)) {
            if ($request->has('remember')) {
                // Tạo cookie với email và mật khẩu
                Cookie::queue('email', $request->email, 604800);
                Cookie::queue('password', $request->password, 604800);
            }
            // Thông báo đăng nhập thành công
            toastr("Xin chào bạn đến với GunDamWin", NotificationInterface::SUCCESS, "Đăng nhập thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return redirect()->route('home'); // Chuyển hướng về trang chủ
        }
        // Nếu thông tin đăng nhập không đúng, thông báo lỗi
        toastr("Thông tin tài khoản hoặc mật khẩu không chính xác", NotificationInterface::ERROR, "Đăng nhập thất bại", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return back(); // Quay lại trang trước
    }
    public function registerView()
    {
        // Trả về trang đăng ký từ view 'client.pages.auth.register'
        return view('client.pages.auth.register');
    }
    public function storeRegister(RegisterRequest $request)
    {
        // Lấy và validate dữ liệu từ form đăng ký
        $validatedData = $request->validated();
        // Tạo người dùng mới từ dữ liệu đã validate
        $user = User::create([
            'full_name' => $validatedData['full_name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // Mã hóa mật khẩu
            'status' => 'ACTIVE', // Đặt trạng thái mặc định là 'ACTIVE'
            'image' => $validatedData['image'] ?? null, // Lưu ảnh (nếu có)
            'phone' => $validatedData['phone'], // Lưu số điện thoại
        ]);
        // Gán vai trò mặc định cho người dùng (nếu cần)
        $user->roles()->sync([1]);
        // Gửi email xác thực tài khoản
        Mail::to($user->email)->send(new VerifyAccount($user));
        // Thông báo đăng ký thành công và yêu cầu xác thực email
        toastr("Vui lòng kiểm tra email để xác thực tài khoản", NotificationInterface::SUCCESS, "Đăng ký tài khoản thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        // Chuyển hướng người dùng đến trang đăng nhập
        return redirect()->route('auth.login-view');
    }
    public function verify($email)
    {
        // Tìm tài khoản với email tương ứng
        $acc = User::where('email', $email)->first();
        // Kiểm tra xem tài khoản đã được xác thực chưa
        if ($acc && !$acc->email_verified_at) {
            // Nếu chưa, cập nhật email_verified_at để xác thực tài khoản
            User::where('email', $email)->update(['email_verified_at' => now()]);

            // Thông báo xác thực thành công
            toastr("Tài khoản của bạn đã được xác thực thành công! <br> Vui lòng đăng nhập tài khoản", NotificationInterface::SUCCESS, "Xác thực tài khoản thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        } elseif ($acc && $acc->email_verified_at) {
            // Nếu tài khoản đã được xác thực trước đó, thông báo lỗi
            toastr("Tài khoản của bạn đã được xác thực trước đó.", NotificationInterface::ERROR, "Xác thực tài khoản", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        } else {
            // Nếu không tìm thấy tài khoản, thông báo lỗi
            toastr("Tài khoản không tồn tại.", NotificationInterface::ERROR, "Xác thực tài khoản", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        }
        // Chuyển hướng người dùng về trang đăng nhập
        return redirect()->route('auth.login-view');
    }
    public function fogetPasswordView()
    {
        // Trả về trang quên mật khẩu từ view 'client.pages.auth.foget-password'
        return view('client.pages.auth.foget-password');
    }
    public function checkfogetPasswordView(FogetPassRequest $request)
    {
        // Tìm người dùng dựa vào email đã nhập
        $user = User::where('email', $request->email)->first();
        // Kiểm tra nếu người dùng tồn tại
        if ($user) {
            // Kiểm tra thời gian yêu cầu đặt lại mật khẩu lần trước (15 phút)
            $timeLimit = now()->subMinutes(15);
            if ($user->updated_at && $user->updated_at > $timeLimit) {
                toastr('Bạn đã yêu cầu lấy lại mật khẩu gần đây, vui lòng thử lại sau 15 phút.', NotificationInterface::WARNING, 'Yêu cầu quá nhiều', [
                    "closeButton" => true,
                    "progressBar" => true,
                    "timeOut" => "3000",
                ]);
                return back();
            }

            // Nếu vượt quá thời gian giới hạn, tiến hành cập nhật mật khẩu
            $newPassword = Str::random(8);

            // Cập nhật mật khẩu mới cho người dùng (mã hóa mật khẩu)
            $user->password = Hash::make($newPassword);
            $user->updated_at = now(); // Cập nhật thời gian thực
            $user->save(); // Lưu tất cả thay đổi

            // Gửi email chứa mật khẩu mới
            Mail::to($user->email)->send(new FogotPass($user, $newPassword));

            // Thông báo thành công
            toastr('Vui lòng kiểm tra email để nhận mật khẩu mới', NotificationInterface::SUCCESS, 'Lấy lại mật khẩu thành công', [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        } else {
            // Nếu không tìm thấy tài khoản, thông báo lỗi
            toastr('Email không tồn tại trong hệ thống', NotificationInterface::ERROR, 'Lấy lại mật khẩu thất bại', [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return back();
        }

        // Đăng xuất người dùng hiện tại
        Auth::logout();

        // Xóa cookie nếu đã lưu thông tin đăng nhập
        Cookie::queue(Cookie::forget('email'));
        Cookie::queue(Cookie::forget('password'));

        // Chuyển hướng lại trang đăng nhập
        return redirect()->route('auth.login-view');
    }

    public function logout(Request $request)
    {
        // Đăng xuất người dùng hiện tại
        Auth::logout();

        // Xóa cookie nếu đã lưu thông tin đăng nhập
        Cookie::queue(Cookie::forget('email'));
        Cookie::queue(Cookie::forget('password'));

        // Thông báo đăng xuất thành công
        toastr("Bạn đã đăng xuất thành công", NotificationInterface::SUCCESS, "Đăng xuất", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);

        // Chuyển hướng về trang đăng nhập hoặc trang chủ
        return redirect()->route('auth.login-view');
    }
    public function changePassword(ChangePassRequest $request)
    {
        $user = Auth::user();
        // Kiểm tra nếu mật khẩu mới trùng với mật khẩu hiện tại
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'Mật khẩu mới không được trùng với mật khẩu hiện tại.']);
        }

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $user->password)) {
            // Khởi tạo số lần cố gắng đổi mật khẩu
            $attempts = session('password_change_attempts', 0) + 1;
            session(['password_change_attempts' => $attempts]);

            // Kiểm tra nếu đã vượt quá 5 lần cố gắng
            if ($attempts >= 5) {
                // Đặt trạng thái người dùng là IN_ACTIVE
                $user->update(['status' => 'IN_ACTIVE']); // Cập nhật trạng thái người dùng

                // Đăng xuất người dùng hiện tại
                Auth::logout();
                Cookie::queue(Cookie::forget('email'));
                Cookie::queue(Cookie::forget('password'));

                // Hiển thị thông báo khóa tài khoản
                sweetalert("Bạn đã nhập mật khẩu không chính xác 5 lần. Tài khoản đã bị khóa.", NotificationInterface::ERROR, [
                    'position' => "center",
                    'timeOut' => '',
                    'closeButton' => false,
                ]);
                return redirect()->route('auth.login-view');
            }

            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác. Bạn còn ' . (5 - $attempts) . ' lần thử']);
        }

        // Đặt lại số lần cố gắng
        session(['password_change_attempts' => 0]);

        // Cập nhật mật khẩu mới
        $user->update(['password' => Hash::make($request->new_password)]); // Sử dụng mật khẩu mới từ request

        // Hiển thị thông báo thành công
        sweetalert("Thay đổi mật khẩu thành công", NotificationInterface::INFO, [
            'position' => "center",
            'timeOut' => '',
            'closeButton' => false,
            'icon' => "success",
        ]);

        return back();
    }
}
