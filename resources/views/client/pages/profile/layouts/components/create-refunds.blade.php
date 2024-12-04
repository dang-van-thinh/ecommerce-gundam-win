@extends('client.pages.profile.layouts.master')

@section('title')
    Chi tiết đơn hoàn hàng
@endsection

@section('profile')
    <div class="dashboard-right-box">
        <div class="order">
            <div class="sidebar-title">
                <div class="loader-line"></div>
                <h4>Hoàn hàng</h4>
            </div>
            <div class="order-detail row">
                <h6>Mã đơn hàng: {{ $order->code }}</h6>
                <h6>Chọn sản phẩm muốn hoàn trong đơn hàng</h6>
                <form action="{{ route('profile.order.store.refunds') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @foreach ($order->orderItems as $item)
                        <div class="address-option" style=" background: white">
                            <label for="refund-checkbox-{{ $item->id }}">
                                <span class="d-flex">
                                    <span class="form-check">
                                        <input type="checkbox" id="refund-checkbox-{{ $item->id }}"
                                            class="refund-checkbox custom-checkbox" data-refunds-id="{{ $item->id }}"
                                            data-id="{{ $item->productVariant->id }}" data-name="{{ $item->product_name }}"
                                            data-variant="{{ $item->productVariant->attributeValues->pluck('name')->implode(' - ') }}"
                                            data-price="{{ number_format($item->product_price) }}"
                                            data-quantity="{{ $item->quantity }}">
                                    </span>
                                    <div class="product-box mb-3">
                                        <div class="d-flex">
                                            <div class="mx-3">
                                                <img width="100px"
                                                    src="{{ '/storage/' . $item->productVariant->product->image }}"
                                                    alt="{{ $item->productVariant->product->name }}" />
                                            </div>
                                            <div>
                                                <p>Tên sản phẩm : {{ $item->product_name }}</p>
                                                <p>Giá: {{ number_format($item->product_price) }} Vnd</p>
                                                <p>Số lượng: {{ $item->quantity }}</p>
                                                <p>Biến thể:
                                                    {{ $item->productVariant->attributeValues->pluck('name')->implode(' - ') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </span>
                                <div id="refunds-{{ $item->id }}"></div>
                            </label>
                        </div>
                    @endforeach
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="mt-3 text-end">
                        <button type="button" id="create-refunds" style="background-color: #c28f51; border:none;"
                            class="btn btn-primary">Tạo đơn hoàn hàng</button>
                        <button type="submit" id="submit-refunds" style="background-color: #c28f51; border:none;"
                            class="btn btn-success">Gửi yêu cầu hoàn hàng</button>
                    </div>
                </form>
            </div>
            <script>
                document.getElementById('create-refunds').addEventListener('click', function() {
                    const selectedItems = document.querySelectorAll('.refund-checkbox:checked');

                    if (selectedItems.length === 0) {
                        alert('Vui lòng chọn ít nhất một sản phẩm để hoàn.');
                        return;
                    }

                    // Tạo form cho từng sản phẩm được chọn
                    selectedItems.forEach((item, index) => {
                        const id = item.getAttribute('data-refunds-id');
                        const refundsContainer = document.getElementById(`refunds-${id}`);

                        // Nếu đã có form trong container, bỏ qua
                        if (refundsContainer.querySelector('.refund-form')) return;

                        const productVariantId = item.getAttribute('data-id');
                        const productVariant = item.getAttribute('data-variant');
                        const productQuantity = item.getAttribute('data-quantity');

                        const formHtml = `
        <div class="refund-form mb-4 p-3" data-refund-id="${id}">
            <input type="hidden" name="refund[${index}][product_variant_id]" value="${productVariantId}">
            
            <!-- Lý do hoàn -->
            <div class="mb-3">
                <label class="form-label">Lý do hoàn:</label>
                <select class="form-select" name="refund[${index}][reason]">
                    <option value="">Vui lòng chọn lý do</option>
                    <option value="NOT_RECEIVED">Chưa nhận được hàng</option>
                    <option value="MISSING_ITEMS">Thiếu sản phẩm</option>
                    <option value="DAMAGED_ITEMS">Sản phẩm bị hư hỏng</option>
                    <option value="INCORRECT_ITEMS">Sản phẩm không đúng</option>
                    <option value="FAULTY_ITEMS">Sản phẩm bị lỗi</option>
                    <option value="DIFFERENT_FROM_DESCRIPTION">Sản phẩm khác mô tả</option>
                    <option value="USED_ITEMS">Sản phẩm đã qua sử dụng</option>
                </select>
                <div class="error-message text-danger"></div>
            </div>

            <!-- Mô tả chi tiết -->
            <div class="mb-3">
                <label class="form-label">Mô tả chi tiết:</label>
                <textarea class="form-control" name="refund[${index}][description]"></textarea>
                <div class="error-message text-danger"></div>
            </div>

            <!-- Số lượng hoàn -->
            <div class="mb-3">
                <label class="form-label">Số lượng hoàn:</label>
                <input type="number" class="form-control" name="refund[${index}][quantity]" max="${productQuantity}" placeholder="Tối đa: ${productQuantity}">
                <div class="error-message text-danger"></div>
            </div>

            <!-- Hình ảnh -->
            <div class="mb-3">
                <label class="form-label">Hình ảnh:</label>
                <input type="file" class="form-control" name="refund[${index}][image]">
                <div class="error-message text-danger"></div>
            </div>
        </div>
        `;
                        refundsContainer.innerHTML += formHtml;
                    });
                });

                // Xóa form khi bỏ chọn sản phẩm
                document.querySelectorAll('.refund-checkbox').forEach((checkbox) => {
                    checkbox.addEventListener('change', function() {
                        const id = this.getAttribute('data-refunds-id');
                        const refundsContainer = document.getElementById(`refunds-${id}`);

                        if (!this.checked) {
                            // Nếu bỏ chọn, xóa form
                            refundsContainer.innerHTML = '';
                        }
                    });
                });

                // Xử lý khi gửi yêu cầu hoàn hàng
                document.getElementById('submit-refunds').addEventListener('click', function(e) {
                    const refundForms = document.querySelectorAll('.refund-form');
                    let isValid = true;

                    refundForms.forEach((form) => {
                        // Reset thông báo lỗi
                        form.querySelectorAll('.error-message').forEach((errorDiv) => {
                            errorDiv.textContent = '';
                        });

                        const quantityInput = form.querySelector('input[name*="[quantity]"]');
                        const quantityMax = parseInt(quantityInput.getAttribute('max'), 10);
                        const imageInput = form.querySelector('input[name*="[image]"]');
                        const reasonSelect = form.querySelector('select[name*="[reason]"]');
                        const descriptionInput = form.querySelector('textarea[name*="[description]"]');

                        // Kiểm tra số lượng
                        if (!quantityInput.value || quantityInput.value > quantityMax || quantityInput.value <= 0) {
                            isValid = false;
                            const errorDiv = quantityInput.nextElementSibling;
                            errorDiv.textContent = `Số lượng không hợp lệ. Tối đa: ${quantityMax}, tối thiểu: 1.`;
                        }

                        // Kiểm tra lý do
                        if (!reasonSelect.value) {
                            isValid = false;
                            const errorDiv = reasonSelect.nextElementSibling;
                            errorDiv.textContent = 'Vui lòng chọn lý do hoàn.';
                        }

                        // Kiểm tra mô tả
                        if (!descriptionInput.value.trim()) {
                            isValid = false;
                            const errorDiv = descriptionInput.nextElementSibling;
                            errorDiv.textContent = 'Mô tả không được bỏ trống.';
                        }

                        // Kiểm tra hình ảnh
                        if (!imageInput.files.length) {
                            isValid = false;
                            const errorDiv = imageInput.nextElementSibling;
                            errorDiv.textContent = 'Vui lòng tải lên ít nhất một hình ảnh.';
                        } else {
                            const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                            const file = imageInput.files[0];
                            if (!validImageTypes.includes(file.type)) {
                                isValid = false;
                                const errorDiv = imageInput.nextElementSibling;
                                errorDiv.textContent = 'Tệp tải lên phải là hình ảnh (JPG, PNG, GIF).';
                            }
                        }
                    });

                    if (!isValid) {
                        e.preventDefault(); // Ngăn gửi form nếu không hợp lệ
                    }
                });
            </script>
        @endsection
