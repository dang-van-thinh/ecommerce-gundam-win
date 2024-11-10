<div class="custom-container container">
    <div class="style-banner">
        <div class="row gy-4 align-items-end">
            @foreach ($leftBanners as $banner)
                
            
            <div class="col-sm-6 col-12 ratio_square-4"><a href="{{$banner->link}}"> <img class="bg-img"
                        src="{{ asset('storage/' . $banner->image_url) }}" alt="" /></a></div>
            <div class="col-sm-6 col-12 ratio3_2">
                <div class="style-content">
                    <h6>Wear Your Style</h6>
                    <h2>{{$banner->title}}</h2>
                    <h4>On Fashion Online Shopping</h4>
                    <div class="link-hover-anim underline"><a
                            class="btn btn_underline link-strong link-strong-unhovered"
                            href="{{$banner->link}}">Shop Collection<svg>
                                <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                            </svg></a><a class="btn btn_underline link-strong link-strong-hovered"
                            href="{{$banner->link}}">Shop Collection<svg>
                                <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                            </svg></a></div>

                </div>
               @endforeach 
               @foreach ($rightBanners as $banner)
                    <a href="{{$banner->link}}"> <img class="bg-img"
                        src="{{ asset('storage/' . $banner->image_url) }}" alt="" /></a>
               @endforeach
               
            </div>
        </div>
    </div>
</div>
