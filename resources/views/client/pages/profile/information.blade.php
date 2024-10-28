@extends('client.pages.profile.layouts.master')
@section('title')
    Thông tin người dùng
@endsection
@section('profile')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
            <div class="dashboard-right-box">
                <div class="my-dashboard-tab">
                    <div class="dashboard-items"> </div>
                    <div class="sidebar-title">
                        <div class="loader-line"></div>
                        <h4>Thông tin người dùng</h4>
                    </div>
                    <div class="dashboard-user-name">
                        <h6>Hello, <b>John Doe</b></h6>
                        <p>My dashboard provides a comprehensive overview of key metrics and data
                            relevant to your operations. It offers real-time insights into performance,
                            including sales figures, website traffic, customer engagement, and more.
                            With customizable widgets and intuitive visualizations, it facilitates quick
                            decision-making and allows you to track progress towards your goals
                            effectively.</p>
                    </div>
                    <div class="total-box">
                        <div class="row gy-4">
                            <div class="col-xl-4">
                                <div class="totle-contain">
                                    <div class="wallet-point"><img src="/template/client/assets/images/svg-icon/wallet.svg"
                                            alt=""><img class="img-1"
                                            src="/template/client/assets/images/svg-icon/wallet.svg" alt=""></div>
                                    <div class="totle-detail">
                                        <h6>Balance</h6>
                                        <h4>$ 84.40 </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="totle-contain">
                                    <div class="wallet-point"><img src="/template/client/assets/images/svg-icon/coin.svg"
                                            alt=""><img class="img-1"
                                            src="/template/client/assets/images/svg-icon/coin.svg" alt=""></div>
                                    <div class="totle-detail">
                                        <h6>Total Points</h6>
                                        <h4>500</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="totle-contain">
                                    <div class="wallet-point"><img src="/template/client/assets/images/svg-icon/order.svg"
                                            alt=""><img class="img-1"
                                            src="/template/client/assets/images/svg-icon/order.svg" alt=""></div>
                                    <div class="totle-detail">
                                        <h6>Total Orders</h6>
                                        <h4>12</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-about">
                        <div class="row">
                            <div class="col-xl-7">
                                <div class="sidebar-title">
                                    <div class="loader-line"></div>
                                    <h5>Profile Information</h5>
                                </div>
                                <ul class="profile-information">
                                    <li>
                                        <h6>Name :</h6>
                                        <p>John Doe</p>
                                    </li>
                                    <li>
                                        <h6>Phone:</h6>
                                        <p>+1 5551855359</p>
                                    </li>
                                    <li>
                                        <h6>Address:</h6>
                                        <p>26, Starts Hollow Colony Denver, Colorado, United States
                                            80014</p>
                                    </li>
                                </ul>
                                <div class="sidebar-title">
                                    <div class="loader-line"></div>
                                    <h5>Login Details</h5>
                                </div>
                                <ul class="profile-information mb-0">
                                    <li>
                                        <h6>Email :</h6>
                                        <p>john.customer@example.com </p>
                                    </li>
                                    <li>
                                        <h6>Mật khẩu :</h6>
                                        <p>●●●●●●<span data-bs-toggle="modal" data-bs-target="#edit-password"
                                                title="Quick View" tabindex="0">Thay đổi</span></p>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xl-5">
                                <div class="profile-image d-none d-xl-block"> <img class="img-fluid"
                                        src="/template/client/assets/images/other-img/dashboard.png" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('client.pages.profile.layouts.components.edit-password')
@endsection
