<div class="product-tab-content ratio1_3">
    <div class="row-cols-lg-4 row-cols-md-3 row-cols-2 grid-section view-option row g-3 g-xl-4" id="product-list">
        @foreach ($products as $product)
        <div>
            <div class="product-box-3">
                <div class="img-wrapper">
                    <div class="label-block">
                        <a class="label-2 wishlist-icon" href="javascript:void(0)" tabindex="0">
                            <i class="iconsax" data-icon="heart" aria-hidden="true"
                                data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i>
                        </a>
                    </div>
                    <div class="product-image overflow-hidden position-relative" style="width: 100%; height: 290px;">
                        <a class="pro-first d-block w-100 h-100" href="{{ route('product', $product->id) }}">
                            <img class="img-fluid w-100 h-100" src="{{ '/storage/' . $product->image }}" alt="product" style="object-fit: cover;">
                        </a>
                        @php
                            $firstImage = $product->productImages->first();
                        @endphp
                        <a class="pro-sec d-block w-100 h-100 position-absolute top-0 start-0" href="{{ route('product', $product->id) }}">
                            <img class="img-fluid w-100 h-100" src="{{ '/storage/' . $firstImage->image_url }}" alt="product" style="object-fit: cover;">
                        </a>
                    </div>                                     
                    <div class="cart-info-icon">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart" tabindex="0">
                            <i class="iconsax" data-icon="basket-2" aria-hidden="true"
                                data-bs-toggle="tooltip" data-bs-title="Add to cart"> </i>
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
                    <div class="listing-button">
                        <a class="btn" href="cart.html">Quick Shop</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>