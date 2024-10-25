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
                                <div>
                                    <div class="blog-img"> <img class="img-fluid bg-img"
                                            src="/template/client/assets/images/other-img/blog-details.jpg" alt="">
                                    </div>
                                </div>
                                <div class="blog-content">
                                    <span class="blog-date">May 9, 2018 Stylish </span><a
                                        href="blog-details.html">
                                        <h4>How Black Trans Women Are Redefining Beauty Standards</h4>
                                    </a>
                                    <p>Sed non mauris vitae erat consequat. Proin gravida nibh vel velit auctor aliquet.
                                        Aenean sollicitudin, lom quis bibenm auctor, nisi elit consequat ipsum, nec
                                        sagittis sem nibh id elit. Duis sed odio sit amet nibh vuutate cursus a sit amet
                                        maorbi We were making our way to the Rila Mountains, where we were visiting the
                                        Rila Monastery where we enjoyed scrambled eggs, toast, mekitsi, local jam and
                                        peppermint tea.</p><span>We wandered the site with busloads of other tourists,
                                        yet strangely the place did not seem crowded. I’m not sure if it was the sheer
                                        size of the place, or whether the masses congregated in one area and didn’t
                                        venture far from the main church, but I didn’t feel overwhelmed by tourists in
                                        the monastery.</span><span class="mb-0">Even though winter is coming to an end,
                                        it's never too late to jump on the winter wear fashion bandwagon. Winter is many
                                        people’s favorite season, especially fashionistas, who see it as an opportunity
                                        to dress up to the nines. Winter lets us layer our clothes, giving us endless
                                        styling options with varied colors, styles, textures, fabrics, prints, and
                                        more.</span>
                                    <div class="quote-title">
                                        <h6><i class="fa-solid fa-quote-left"></i><span>Fashion you can buy, but style
                                                you possess. The key to style is learning who you are, which takes
                                                years. There's no how-to road map to style. It's about self expression
                                                and, above all, attitude. </span></h6>
                                    </div><span class="mt-0">I had low expectations about Sofia as a city, but after the
                                        walking tour I absolutely loved the place. This was an easy city to navigate,
                                        and it was a beautiful city – despite its ugly, staunch and stolid
                                        communist-built surrounds. Sofia has a very average facade as you enter the
                                        city, but once you lose yourself in the old town area, everything
                                        changes.Feeling refreshed after an espresso, we walked a short distance to the
                                        small but welcoming Banya Bashi Mosque, then descended into the ancient Serdica
                                        complex.</span>
                                    <h5 class="pt-3">You Might Be Interested In</h5>
                                    <ul>
                                        <li>Mid seat coverage Non wired powermesh back liner low curve to the reverse
                                            fixed straps quick drying comfortable.</li>
                                        <li>Bodycon skirts bright primary colours punchy palette pleated cheerleader
                                            vibe stripe trims.</li>
                                        <li>Statement buttons cover-up tweaks patch pockets perennial lapel collar flap
                                            chest pockets topline stitching cropped jacket.</li>
                                    </ul>
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
                                            <textarea class="form-control" id="message" rows="6" placeholder="Enter Your Message"></textarea>
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
                            <div class="col-12">
                                <div class="blog-search"> <input type="search" placeholder="Search Here..."><i
                                        class="iconsax" data-icon="search-normal-2"></i></div>
                            </div>
                            <div class="col-12">
                                <div class="sidebar-box">
                                    <div class="sidebar-title">
                                        <div class="loader-line"></div>
                                        <h5> Categories</h5>
                                    </div>
                                    <ul class="categories">
                                        <li>
                                            <p>Fashion<span>30</span></p>
                                        </li>
                                        <li>
                                            <p>Trends<span>20</span></p>
                                        </li>
                                        <li>
                                            <p>Designer<span>3</span></p>
                                        </li>
                                        <li>
                                            <p>Swimwear<span>15</span></p>
                                        </li>
                                        <li>
                                            <p>Handbags<span>11</span></p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="sidebar-box">
                                    <div class="sidebar-title">
                                        <div class="loader-line"></div>
                                        <h5> Top Post</h5>
                                    </div>
                                    <ul class="top-post">
                                        <li> <img class="img-fluid"
                                                src="/template/client/assets/images/other-img/blog-1.jpg" alt="">
                                            <div> <a href="blog-details.html">
                                                    <h6>Study 2020: Fake Engagement is Only Half the Problem</h6>
                                                </a>
                                                <p>September 28, 2021</p>
                                            </div>
                                        </li>
                                        <li> <img class="img-fluid"
                                                src="/template/client/assets/images/other-img/blog-2.jpg" alt="">
                                            <div> <a href="blog-details.html">
                                                    <h6>Top 10 Interior Design in 2020 New York Business</h6>
                                                </a>
                                                <p>September 28, 2021</p>
                                            </div>
                                        </li>
                                        <li> <img class="img-fluid"
                                                src="/template/client/assets/images/other-img/blog-3.jpg" alt="">
                                            <div> <a href="blog-details.html">
                                                    <h6>Ecommerce Brands Tend to Create Strong Communities</h6>
                                                </a>
                                                <p>September 28, 2021</p>
                                            </div>
                                        </li>
                                        <li> <img class="img-fluid"
                                                src="/template/client/assets/images/other-img/blog-4.jpg" alt="">
                                            <div> <a href="blog-details.html">
                                                    <h6>What Do I Need to Make It in the World of Business?</h6>
                                                </a>
                                                <p>September 28, 2021</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12">
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
                            </div>
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
                            <div class="col-12 d-none d-lg-block">
                                <div class="blog-offer-box"> <img class="img-fluid"
                                        src="/template/client/assets/images/other-img/blog-offer.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
