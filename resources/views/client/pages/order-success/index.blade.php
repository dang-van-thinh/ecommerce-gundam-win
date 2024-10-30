@extends('client.layouts.master')
@section('title')
    Mua hàng thành công
@endsection
@section('content')
    <section class="section-b-space py-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 px-0">
                    <div class="order-box-1"><img src="/template/client/assets/images/gif/success.gif" alt="">
                        <h4>Đặt hàng thành công</h4>
                        <p>Thanh toán đã được xử lý thành công và đơn hàng của bạn đang trên đường</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space">
        <div class="custom-container order-success container">
            <div class="row gy-4">
                <div class="col-xl-8">
                    <div class="order-items sticky">
                        <h4>Thông tin đặt hàng</h4>
                        <p>
                            Hóa đơn đặt hàng đã được gửi đến tài khoản email đã đăng ký của bạn. Kiểm tra lại thông tin chi
                            tiết đơn hàng của bạn
                        </p>
                        <div class="order-table">
                            <div class="table-responsive theme-scrollbar">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm </th>
                                            <th>Giá </th>
                                            <th>Số lượng</th>
                                            <th>Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->orderItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="cart-box">
                                                        <a href="product.html">
                                                            <img src="/template/client/assets/images/cart/category/1.jpg"
                                                                alt="">
                                                        </a>
                                                        <div>
                                                            <a href="product.html">
                                                                <h5>{{ $item->product_name }}</h5>
                                                            </a>
                                                            @foreach ($item->productVariant->attributeValues as $attributeValue)
                                                                <p>{{ $attributeValue->attribute->name }}:
                                                                    <span>{{ $attributeValue->name }}</span>
                                                                </p>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ number_format($item->product_price) }} VND</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->total_price) }} VND</td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td> </td>
                                            <td></td>
                                            <td class="total fw-bold">Tổng : </td>
                                            <td class="total fw-bold">{{ number_format($data->total_amount) }} VND</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="summery-box">
                        <div class="sidebar-title">
                            <div class="loader-line"></div>
                            <h4>Chi tiết đơn hàng</h4>
                        </div>
                        <div class="summery-content">
                            <ul>
                                <li>
                                    <p class="fw-semibold">Tổng sản phẩm ({{ count($data->orderItems) }})</p>
                                    <h6>$230.00</h6>
                                </li>
                                <li>
                                    <p>Shipping to </p><span>united kingdom</span>
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <p>shipping Costs</p><span>$0.00</span>
                                </li>
                                <li>
                                    <p>Total without VAT </p><span>$250.00</span>
                                </li>
                                <li>
                                    <p>Including 10% VAT </p><span>$25.00</span>
                                </li>
                                <li>
                                    <p>Discount Code </p><span>$-10.00</span>
                                </li>
                            </ul>
                            <div class="d-flex align-items-center justify-content-between">
                                <h6>Tổng cộng</h6>
                                <h5>{{ number_format($data->discount_amount) }} VND</h5>
                            </div>
                            <div class="note-box">
                                <p>Tôi hy vọng cửa hàng có thể làm việc với tôi để giao hàng sớm nhất có thể vì tôi thực sự
                                    cần nó để tặng cho bạn tôi vào bữa tiệc tuần tới. Cảm ơn bạn rất nhiều.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="summery-footer">
                        <div class="sidebar-title">
                            <div class="loader-line"></div>
                            <h4>Địa chỉ giao hàng</h4>
                        </div>
                        <ul>
                            <li>
                                <h6>8424 James Lane South</h6>
                                <h6>San Francisco, CA 94080</h6>
                            </li>
                            <li>
                                <h6>Expected Date Of Delivery: <span>Track Order</span></h6>
                            </li>
                            <li>
                                <h5>Oct 21, 2021</h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
