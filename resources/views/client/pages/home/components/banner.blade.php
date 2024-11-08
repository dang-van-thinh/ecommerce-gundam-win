<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-2 d-none d-xl-block">
            <ul>
                <li> <a href="collection-left-sidebar.html">Women’s Clothing</a></li>
                <li> <a href="collection-left-sidebar.html">Men’s Clothing</a></li>
                <li> <a href="collection-left-sidebar.html">Kids Clothing</a></li>
                <li> <a href="collection-left-sidebar.html">Watch</a></li>
                <li> <a href="collection-left-sidebar.html">Sports Accessories</a></li>
                <li> <a href="collection-left-sidebar.html">Sunglass</a></li>
                <li> <a href="collection-left-sidebar.html">Bags</a></li>
                <li> <a href="collection-left-sidebar.html">Sneakers</a></li>
                <li> <a href="collection-left-sidebar.html">Jewellery</a></li>
                <li> <a href="collection-left-sidebar.html">Hair Accessories</a></li>
                <li> <a href="collection-left-sidebar.html">Other</a></li>
            </ul>
        </div>
        <div class="col pe-0">
            @foreach ($headerBanners as $banner)            
            <div class="home-banner p-right"> <img class="img-fluid" src="{{ asset('storage/' . $banner->image_url) }}"
                    alt="{{$banner->title}}" />
                <div class="contain-banner">
                    <div>
                        <h4>Hot Offer <span>START TODAY</span></h4>
                        <h1>{{$banner->title}}</h1>
                        <p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. </p>
                        <div class="link-hover-anim underline"><a
                                class="btn btn_underline link-strong link-strong-unhovered"
                                href="{{$banner->link}}">Show Now<svg>
                                    <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                                </svg></a><a class="btn btn_underline link-strong link-strong-hovered"
                                href="{{$banner->link}}">Show Now<svg>
                                    <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                                </svg></a></div>
                    </div>
                </div>
            </div>
            @endforeach
            <ul class="social-icon">
                <li> <a href="#">
                        <h6>Follow Us</h6>
                    </a></li>
                <li> <a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                </li>
                <li> <a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                </li>
            </ul>
        </div>
    </div>
</div>
