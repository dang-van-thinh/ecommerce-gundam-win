@extends('client.layouts.master')
@section('title')
    Quên mật khẩu
@endsection
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Quên mật khẩu',
        'parent' => [
            'route' => '',
            'name' => 'Trang chủ',
        ],
    ]);
    <section class="section-b-space login-bg-img pt-0">
        <div class="custom-container login-page container">
            <div class="row align-items-center">
                <div class="col-xxl-7 col-6 d-none d-lg-block">
                    <div class="login-img"> <img class="img-fluid" src="/template/client/assets/images/login/1.svg"
                            alt=""></div>
                </div>
                <div class="col-xxl-4 col-lg-6 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h4>Welcome To katie</h4>
                            <p>Forgot your password</p>
                        </div>
                        <div class="login-box">
                            <form class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating"><input class="form-control" id="floatingInputValue"
                                            type="email" placeholder="name@example.com" value="test@example.com"><label
                                            for="floatingInputValue">Enter Your Email</label></div>
                                </div>
                                <div class="col-12"> <a class="btn login btn_black sm" href="otp.html">Gửi mã</a>
                                </div>
                            </form>
                        </div>
                        <div class="other-log-in"></div>
                        <div class="sign-up-box">
                            <a class="text-decoration-underline" href="{{ route('auth.login-view') }}">Trở về Đăng nhập</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection