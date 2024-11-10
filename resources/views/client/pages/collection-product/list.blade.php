<div class="product-tab-content ratio1_3">
    <div class="row-cols-lg-4 row-cols-md-3 row-cols-2 grid-section view-option row g-3 g-xl-4" id="product-list">
        @foreach ($products as $product)
            <div>
                <div class="product-box-3">
                    <div class="img-wrapper">
                        <div class="label-block">
                            <a class="label-2 wishlist-icon" data-id="{{ $product->id }}" tabindex="0">
                                <i class="fa-regular fa-heart"
                                    style="{{ $product->favorites->isNotEmpty() ? 'display: none;' : '' }}"></i>
                                <i class="fa-solid fa-heart"
                                    style="color: red; {{ $product->favorites->isNotEmpty() ? '' : 'display: none;' }}"></i>
                            </a>
                        </div>
                        <div class="product-image ratio_apos">
                                        <a class="pro-first" href="{{ route('product', $product->id) }}">
                                            <img class="bg-img" src="{{ '/storage/' . $product->image }}"
                                                alt="product" />
                                        </a>
                                        @php
                                            $firstImage = $product->productImages->first();
                                        @endphp
                                        <a class="pro-sec" href="{{ route('product', $product->id) }}">
                                            <img class="bg-img" src="{{ '/storage/' . $firstImage->image_url }}"
                                                alt="product" />
                                        </a>
                                    </div>
                    </div>
                    <div class="product-detail">
                        <ul class="rating">
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star-half-stroke"></i></li>
                            <li><i class="fa-regular fa-star"></i></li>
                            <li>4.3</li>
                        </ul>
                        <a href="{{ route('product', $product->id) }}">
                            <h6>{{ $product->name }}</h6>
                        </a>
                        <p>
                            @if ($product->productVariants->count() === 1)
                                {{ number_format($product->productVariants->first()->price, 0, ',', '.') }}₫
                            @else
                                {{ number_format($product->productVariants->min('price'), 0, ',', '.') }}₫-
                                {{ number_format($product->productVariants->max('price'), 0, ',', '.') }}₫
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.wishlist-icon', function (e) {
                var productId = $(this).data('id');
                var icon = $(this).find('i');

                $.ajax({
                    url: '{{ route("toggle.favorite") }}',
                    method: 'POST',
                    data: {
                        userId: @php
                            echo Auth::id();
                        @endphp,
                        product_id: productId
                    },
                    success: function (response) {
                    console.log("love or not love",response);
                        document.querySelector('#love').innerText = response.love
                        if (response.status === 'added') {
                            icon.eq(0).hide();  // Ẩn trái tim chưa yêu thích
                            icon.eq(1).show();  // Hiển thị trái tim đã yêu thích
                        } else {
                            icon.eq(1).hide();  // Ẩn trái tim đã yêu thích
                            icon.eq(0).show();  // Hiển thị trái tim chưa yêu thích
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('Có lỗi xảy ra!');
                    }
                });
            });
        });
    </script>
@endpush
