<div class="container-fluid">
    <div class="row">
        <div class="col-2 d-none d-xl-block">
            <ul style="padding-left: 0; text-align: left; list-style: none;">
                @isset($categoryProduct)
                    @foreach ($categoryProduct as $cate)
                        <li style="margin-bottom: 8px;">
                            <a href="{{ route('collection-product', $cate->id) }}"
                                style="text-decoration: none; color: inherit;">
                                {{ $cate->name }}
                            </a>
                        </li>
                    @endforeach
                @else
                    <li style="margin-bottom: 8px;">Không có danh mục nào</li>
                @endisset
            </ul>
        </div>
        <div class="col pe-0">
            @if ($headerBanners)
                <div class="home-banner p-right"> <img class="img-fluid"
                        src="{{ asset('storage/' . $headerBanners->image_url) }}" alt="{{ $headerBanners->title }}" />
                </div>
            @else
                <div class="home-banner p-right"> <img class="img-fluid"
                        src="/template/client/assets/images/layout-3/1.jpg" alt="" />
                </div>
            @endif

            {{-- <ul class="social-icon">
                <li> <a href="#">
                        <h6>Theo dõi</h6>
                    </a></li>
                <li> <a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                </li>
                <li> <a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                </li>
            </ul> --}}
        </div>
    </div>
</div>
