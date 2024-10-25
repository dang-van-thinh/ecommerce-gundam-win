@extends('client.layouts.master')
@section('title')
Bài viết
@endsection
@section('content')
@include('client.pages.components.breadcrumb', [
'pageHeader' => 'Bài viết',
'parent' => [
'route' => '',
'name' => 'Trang chủ',
],
]);
<section class="section-b-space pt-0">
    <div class="custom-container blog-page container">
        <div class="row gy-4">
            <div class="col-xl-9 col-lg-8 col-12 ratio50_2">
                <div class="row">
                    <div class="col-12">
                        <div class="blog-main-box blog-details">
                            <div class="blog">
                                <h4>{{ $articles->title }}</h4>
                                <hr>
                                <p>{!!$articles->content!!}</p>
                                <div class="comments-box">
                                    <h5>Comments </h5>
                                    <ul class="theme-scrollbar">
                                        <li>
                                            <div class="comment-items">
                                                <div class="user-img"> <img
                                                        src="/template/client/assets/images/user/1.jpg" alt="">
                                                </div>
                                                <div class="user-content">
                                                    <div class="user-info">
                                                        <div class="d-flex justify-content-between gap-3">
                                                            <h6> <i class="iconsax" data-icon="user-1"></i>Michel
                                                                Poe</h6><span> <i class="iconsax"
                                                                    data-icon="clock"></i>Mar 29, 2022</span>
                                                        </div>
                                                        <ul class="rating mb p-0">
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-regular fa-star"></i></li>
                                                        </ul>
                                                    </div>
                                                    <p>Khaki cotton blend military jacket flattering fit mock horn
                                                        buttons and patch pockets showerproof black lightgrey.
                                                        Printed lining patch pockets jersey blazer built in pocket
                                                        square wool casual quilted jacket without hood azure.</p><a
                                                        href="#"> <span> <i class="iconsax" data-icon="undo"></i>
                                                            Replay</span></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="reply">
                                            <div class="comment-items">
                                                <div class="user-img"> <img
                                                        src="/template/client/assets/images/user/2.jpg" alt="">
                                                </div>
                                                <div class="user-content">
                                                    <div class="user-info">
                                                        <div class="d-flex justify-content-between gap-3">
                                                            <h6> <i class="iconsax" data-icon="user-1"></i>Michel
                                                                Poe</h6><span> <i class="iconsax"
                                                                    data-icon="clock"></i>Mar 29, 2022</span>
                                                        </div>
                                                        <ul class="rating mb p-0">
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-regular fa-star"></i></li>
                                                        </ul>
                                                    </div>
                                                    <p>Khaki cotton blend military jacket flattering fit mock horn
                                                        buttons and patch pockets showerproof black lightgrey.
                                                        Printed lining patch pockets jersey blazer built in pocket
                                                        square wool casual quilted jacket without hood azure.</p><a
                                                        href="#"> <span> <i class="iconsax" data-icon="undo"></i>
                                                            Replay</span></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="comment-items">
                                                <div class="user-img"> <img
                                                        src="/template/client/assets/images/user/3.jpg" alt="">
                                                </div>
                                                <div class="user-content">
                                                    <div class="user-info">
                                                        <div class="d-flex justify-content-between gap-3">
                                                            <h6> <i class="iconsax" data-icon="user-1"></i>Michel
                                                                Poe</h6><span> <i class="iconsax"
                                                                    data-icon="clock"></i>Mar 29, 2022</span>
                                                        </div>
                                                        <ul class="rating mb p-0">
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-regular fa-star"></i></li>
                                                        </ul>
                                                    </div>
                                                    <p>Khaki cotton blend military jacket flattering fit mock horn
                                                        buttons and patch pockets showerproof black lightgrey.
                                                        Printed lining patch pockets jersey blazer built in pocket
                                                        square wool casual quilted jacket without hood azure.</p><a
                                                        href="#"> <span> <i class="iconsax" data-icon="undo"></i>
                                                            Replay</span></a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <h5 class="pt-3">Leave a Comment</h5>
                                <div class="row gy-3 message-box">
                                    <div class="col-sm-6"> <label class="form-label">Full Name</label><input
                                            class="form-control" type="text" placeholder="Enter your Name"></div>
                                    <div class="col-sm-6"> <label class="form-label">Email address</label><input
                                            class="form-control" type="email" placeholder="Enter your Email"></div>
                                    <div class="col-12"> <label class="form-label">Message</label>
                                        <textarea class="form-control" id="message" rows="6"
                                            placeholder="Enter Your Message"></textarea>
                                    </div>
                                    <div class="col-12"> <button class="btn btn_black sm rounded" type="submit">Post
                                            Comment </button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 order-lg-first col-12">
                <div class="blog-sidebar sticky">
                    <div class="row gy-4">
                        {{-- <div class="col-12">
                            <div class="blog-search"> <input type="search" placeholder="Search Here..."><i
                                    class="iconsax" data-icon="search-normal-2"></i></div>
                        </div> --}}
                        <div class="col-12">
                            <div class="sidebar-box">
                                <div class="sidebar-title">
                                    <div class="loader-line"></div>
                                    <h5> Thể loại</h5>
                                </div>
                                <ul class="categories">
                                    @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('category-blog', $category->id) }}">
                                            <p>{{ $category->name }}&nbsp;&nbsp;&nbsp;&nbsp;
                                                <span style="color: red">{{ $category->articles_count }}</span>
                                            </p>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="sidebar-box">
                                <div class="sidebar-title">
                                    <div class="loader-line"></div>
                                    <h5> Bài viết mới</h5>
                                </div>
                                <ul class="top-post">
                                    @foreach($latestPosts as $post)
                                    <li>
                                        <img class="img-fluid" src="{{ asset('storage/' . $post->image) }}"
                                            alt="{{ $post->title }}">
                                        <div>
                                            <a href="{{ route('blog', $post->id) }}">
                                                <h6>{{ $post->title }}</h6>
                                            </a>
                                            <p>{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</p>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        {{-- <div class="col-12">
                            <div class="sidebar-box">
                                <div class="sidebar-title">
                                    <div class="loader-line"></div>
                                    <h5> Popular Tags</h5>
                                </div>
                                <ul class="popular-tag">
                                    <li>
                                        <p>T-shirt</p>
                                    </li>
                                    <li>
                                        <p>Handbags </p>
                                    </li>
                                    <li>
                                        <p>Trends </p>
                                    </li>
                                    <li>
                                        <p>Fashion</p>
                                    </li>
                                    <li>
                                        <p>Designer</p>
                                    </li>
                                </ul>
                            </div>
                        </div> --}}
                        <div class="col-12">
                            <div class="sidebar-box">
                                <div class="sidebar-title">
                                    <div class="loader-line"></div>
                                    <h5>Follow Us</h5>
                                </div>
                                <ul class="social-icon">
                                    <li> <a href="https://www.facebook.com/" target="_blank">
                                            <div class="icon"><i class="fa-brands fa-facebook-f"></i></div>
                                            <h6>Facebook</h6>
                                        </a></li>
                                    <li> <a href="https://www.instagram.com/" target="_blank">
                                            <div class="icon"><i class="fa-brands fa-instagram"> </i></div>
                                            <h6>Instagram</h6>
                                        </a></li>
                                    <li> <a href="https://twitter.com/" target="_blank">
                                            <div class="icon"><i class="fa-brands fa-x-twitter"></i></div>
                                            <h6>Twitter</h6>
                                        </a></li>
                                    <li> <a href="https://www.youtube.com/" target="_blank">
                                            <div class="icon"><i class="fa-brands fa-youtube"></i></div>
                                            <h6>Youtube</h6>
                                        </a></li>
                                    <li> <a href="https://www.whatsapp.com/" target="_blank">
                                            <div class="icon"><i class="fa-brands fa-whatsapp"></i></div>
                                            <h6>Whatsapp</h6>
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                        {{-- <div class="col-12 d-none d-lg-block">
                            <div class="blog-offer-box"> <img class="img-fluid"
                                    src="/template/client/assets/images/other-img/blog-offer.jpg" alt="">
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection