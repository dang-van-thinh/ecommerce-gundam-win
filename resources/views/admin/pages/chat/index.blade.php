@extends('admin.layouts.master')
@section('title')
    Nhắn tin
@endsection
@section('content')
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-4 p-0 m-0">
                <div class="card overflow-auto" style="max-height: 85vh">
                    <div class="card-body">
                        <div class="d-flex flex-row justify-content-start mb-4">
                            <img
                                src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                alt="avatar 1" style="width: 45px; height: 100%;">

                            <div class="d-flex flex-column flex-shrink-0 ms-2">
                                <h3 class="fs-6">Nguyenx van a</h3>
                                <p class="my-1" style="font-size: 12px">heloo my frined</p>
                            </div>
                        </div>
                        <div class="d-flex flex-row justify-content-start mb-4">
                            <img
                                src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                alt="avatar 1" style="width: 45px; height: 100%;">
                            <div class="p-3 ms-3"
                                 style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                <p class="small mb-0">Hello and thank you for visiting MDBootstrap.
                                    Please click the video
                                    below.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8 p-0 m-0">
                <section>
                    <div class="container">
                        <div class="row d-flex">
                            <div class="col-12" style="height: 85vh">
                                <div class="card h-100 overflow-auto position-relative h-100" id="chat1"
                                     style="border-radius: 15px;">
                                    <div
                                        class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0"
                                        style="border-top-left-radius: 15px; border-top-right-radius: 15px; max-height: 4rem;">
                                        <div class="flex-shrink-0 flex-grow-1 overflow-hidden">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="position-relative w-50 d-flex align-items-center justify-content-start h-50">
                                                    <img src="/template/images/admin.jpg" width="40px"
                                                         class="rounded-circle" alt="">
                                                    <div
                                                        class=" d-flex h-100 flex-column justify-content-center align-items-center mx-2 pt-2">
                                                        <h5>Lisa Pink</h5>
                                                        <p class="text-white-50">Online</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-row justify-content-start mb-4">
                                            <img
                                                src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                            <div class="p-3 ms-3"
                                                 style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                                <p class="small mb-0">Hello and thank you for visiting MDBootstrap.
                                                    Please click the video
                                                    below.</p>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row justify-content-end mb-4">
                                            <div class="p-3 me-3 border bg-body-tertiary"
                                                 style="border-radius: 15px;">
                                                <p class="small mb-0">Thank you, I really like your product.</p>
                                            </div>
                                            <img
                                                src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava2-bg.webp"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                        </div>

                                        <div class="d-flex flex-row justify-content-start mb-4">
                                            <img
                                                src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                            <div class="ms-3" style="border-radius: 15px;">
                                                <div class="bg-image">
                                                    <img
                                                        src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/screenshot1.webp"
                                                        style="border-radius: 15px;" alt="video">
                                                    <a href="#!">
                                                        <div class="mask"></div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row justify-content-start mb-4">
                                            <img
                                                src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                            <div class="p-3 ms-3"
                                                 style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                                <p class="small mb-0">...</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body position-absolute bottom-0">
                                        <form>
                                            <div class="row">

                                                <div class="col-10">
                                                    <textarea type="text" cols="1" rows="1"
                                                              class="form-control"></textarea>
                                                </div>
                                                <div class="col-2">
                                                    <button class="btn btn-primary">Gửi</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
