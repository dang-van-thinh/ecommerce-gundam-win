<div class="container-fluid subscribe-banner">
    <div class="row align-items-center">
        @foreach ($subscribeNowEmailBanners as $banner)
        <div class="col-xl-8 col-md-7 col-12 px-0"> <a href="{{$banner->link}}"><img class="bg-img"
                    src="{{ asset('storage/' . $banner->image_url) }}" alt="" /></a></div>
         @endforeach           
        <div class="col-xl-4 col-5">
            <div class="subscribe-content">
                <h6>GET 20% OFF</h6>
                <h4>Subscribe to Our Newsletter!</h4>
                <p>Join the insider list - you’ll be the first to know about new arrivals, insider - only
                    discounts and receive $15 off your first order.</p><input type="text" name="text"
                    placeholder="Your email address..." />
                <div class="link-hover-anim underline"><a
                        class="btn btn_underline link-strong link-strong-unhovered" href="index.html">Subscribe
                        Now<svg>
                            <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                        </svg></a><a class="btn btn_underline link-strong link-strong-hovered"
                        href="index.html">Subscribe Now<svg>
                            <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                        </svg></a></div>
            </div>
        </div>
    </div>
</div>