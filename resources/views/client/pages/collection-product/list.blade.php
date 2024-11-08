<div class="product-tab-content ratio1_3">
    <div class="row-cols-lg-4 row-cols-md-3 row-cols-2 grid-section view-option row g-3 g-xl-4" id="product-list">
        @foreach ($products as $product)
            <div>
                <div class="product-box-3">
                    <div class="img-wrapper">
                        <div class="label-block">
                            <a class="label-2 wishlist-icon" href="javascript:void(0)" tabindex="0">

                                <svg width="24" height="24" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 21.6516C11.69 21.6516 11.39 21.6116 11.14 21.5216C7.32 20.2116 1.25 15.5616 1.25 8.69156C1.25 5.19156 4.08 2.35156 7.56 2.35156C9.25 2.35156 10.83 3.01156 12 4.19156C13.17 3.01156 14.75 2.35156 16.44 2.35156C19.92 2.35156 22.75 5.20156 22.75 8.69156C22.75 15.5716 16.68 20.2116 12.86 21.5216C12.61 21.6116 12.31 21.6516 12 21.6516ZM7.56 3.85156C4.91 3.85156 2.75 6.02156 2.75 8.69156C2.75 15.5216 9.32 19.3216 11.63 20.1116C11.81 20.1716 12.2 20.1716 12.38 20.1116C14.68 19.3216 21.26 15.5316 21.26 8.69156C21.26 6.02156 19.1 3.85156 16.45 3.85156C14.93 3.85156 13.52 4.56156 12.61 5.79156C12.33 6.17156 11.69 6.17156 11.41 5.79156C10.48 4.55156 9.08 3.85156 7.56 3.85156Z"
                                        fill="black"/>
                                </svg>

                            </a>
                        </div>
                        <div class="product-image position-relative overflow-hidden"
                            style="width: 100%; height: 290px;">
                            <a class="pro-first d-block w-100 h-100" href="{{ route('product', $product->id) }}">
                                <img class="img-fluid w-100 h-100" src="{{ '/storage/' . $product->image }}"
                                    alt="product" style="object-fit: cover;">
                            </a>
                            @php
                                $firstImage = $product->productImages->first();
                            @endphp
                            <a class="pro-sec d-block w-100 h-100 position-absolute start-0 top-0"
                                href="{{ route('product', $product->id) }}">
                                <img class="img-fluid w-100 h-100" src="{{ '/storage/' . $firstImage->image_url }}"
                                    alt="product" style="object-fit: cover;">
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
