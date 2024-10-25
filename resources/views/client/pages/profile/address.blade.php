@extends('client.pages.profile.layouts.master')
@section('title')
    Địa chỉ người dùng
@endsection
@section('profile')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="dashboard-right-box">
            <div class="address-tab">
                <div class="sidebar-title">
                    <div class="loader-line"></div>
                    <h4>Địa chỉ người dùng</h4>
                </div>
                <div class="row gy-3">
                    <div class="col-xxl-4 col-md-6">
                        <div class="address-option"><label for="address-billing-0"> <span class="delivery-address-box"> <span
                                        class="form-check"> <input class="custom-radio" id="address-billing-0"
                                            type="radio" checked="checked" name="radio"></span><span
                                        class="address-detail"><span class="address"> <span class="address-title">New Home
                                            </span></span><span class="address"> <span class="address-home"> <span
                                                    class="address-tag"> Address:</span>26, Starts
                                                Hollow Colony, Denver, Colorado, United
                                                States</span></span><span class="address"> <span class="address-home"> <span
                                                    class="address-tag">Pin
                                                    Code:</span>80014</span></span><span class="address"> <span
                                                class="address-home"> <span class="address-tag">Phone :</span>+1
                                                5551855359</span></span></span></span><span class="buttons"> <a
                                        class="btn btn_black sm" href="#" data-bs-toggle="modal"
                                        data-bs-target="#edit-box" title="Quick View" tabindex="0">Edit </a><a
                                        class="btn btn_outline sm" href="#" data-bs-toggle="modal"
                                        data-bs-target="#bank-card-modal" title="Quick View" tabindex="0">Delete
                                    </a></span></label></div>
                    </div>
                    <div class="col-xxl-4 col-md-6">
                        <div class="address-option"><label for="address-billing-3"> <span class="delivery-address-box">
                                    <span class="form-check"> <input class="custom-radio" id="address-billing-3"
                                            type="radio" name="radio"></span><span class="address-detail"><span
                                            class="address"> <span class="address-title">IT
                                                Office</span></span><span class="address"> <span class="address-home"> <span
                                                    class="address-tag">
                                                    Address:</span>55B, Claire Cav Street, San Jose,
                                                California, United States</span></span><span class="address"> <span
                                                class="address-home"> <span class="address-tag">Pin
                                                    Code:</span>94088</span></span><span class="address"> <span
                                                class="address-home"> <span class="address-tag">Phone :</span>+1
                                                5551855359</span></span></span></span><span class="buttons"> <a
                                        class="btn btn_black sm" href="#" data-bs-toggle="modal"
                                        data-bs-target="#edit-box" title="Quick View" tabindex="0">Edit </a><a
                                        class="btn btn_outline sm" href="#" data-bs-toggle="modal"
                                        data-bs-target="#bank-card-modal" title="Quick View"
                                        tabindex="0">Delete</a></span></label></div>
                    </div>
                    <div class="col-xxl-4 col-md-6">
                        <div class="address-option"><label for="address-billing-2"> <span class="delivery-address-box">
                                    <span class="form-check"> <input class="custom-radio" id="address-billing-2"
                                            type="radio" name="radio"></span><span class="address-detail"><span
                                            class="address"> <span class="address-title">IT
                                                Office</span></span><span class="address"> <span class="address-home"> <span
                                                    class="address-tag">
                                                    Address:</span>55B, Claire Cav Street, San Jose,
                                                California, United States</span></span><span class="address"> <span
                                                class="address-home"> <span class="address-tag">Pin
                                                    Code:</span>94088</span></span><span class="address"> <span
                                                class="address-home"> <span class="address-tag">Phone :</span>+1
                                                5551855359</span></span></span></span><span class="buttons"> <a
                                        class="btn btn_black sm" href="#" data-bs-toggle="modal"
                                        data-bs-target="#edit-box" title="Quick View" tabindex="0">Edit </a><a
                                        class="btn btn_outline sm" href="#" data-bs-toggle="modal"
                                        data-bs-target="#bank-card-modal" title="Quick View"
                                        tabindex="0">Delete</a></span></label></div>
                    </div>
                    <div class="col-xxl-4 col-md-6">
                        <div class="address-option"><label for="address-billing-2"> <span class="delivery-address-box">
                                    <span class="form-check"> <input class="custom-radio" id="address-billing-2"
                                            type="radio" name="radio"></span><span class="address-detail"><span
                                            class="address"> <span class="address-title">IT
                                                Office</span></span><span class="address"> <span class="address-home">
                                                <span class="address-tag">
                                                    Address:</span>55B, Claire Cav Street, San Jose,
                                                California, United States</span></span><span class="address"> <span
                                                class="address-home"> <span class="address-tag">Pin
                                                    Code:</span>94088</span></span><span class="address"> <span
                                                class="address-home"> <span class="address-tag">Phone :</span>+1
                                                5551855359</span></span></span></span><span class="buttons"> <a
                                        class="btn btn_black sm" href="#" data-bs-toggle="modal"
                                        data-bs-target="#edit-box" title="Quick View" tabindex="0">Edit </a><a
                                        class="btn btn_outline sm" href="#" data-bs-toggle="modal"
                                        data-bs-target="#bank-card-modal" title="Quick View"
                                        tabindex="0">Delete</a></span></label></div>
                    </div>
                </div><button class="btn add-address" data-bs-toggle="modal" data-bs-target="#add-address"
                    title="Quick View" tabindex="0">+ Add
                    Address</button>
            </div>
        </div>
    </div>
@endsection
