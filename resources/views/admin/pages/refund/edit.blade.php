@extends('admin.layouts.master')

@section('title')
    Cập nhật trạng thái đơn hoàn hàng
@endsection
<style>
    #imgModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        /* Màu nền mờ */
        justify-content: center;
        align-items: center;
        z-index: 1000;
        /* Đảm bảo modal nằm trên các thành phần khác */
    }

    #imgModal img {
        max-width: 90%;
        max-height: 90%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        /* Đổ bóng cho ảnh lớn */
        border: 2px solid white;
        /* Viền trắng cho ảnh */
    }

    #imgModal span {
        position: absolute;
        top: 10px;
        right: 20px;
        color: white;
        font-size: 24px;
        cursor: pointer;
    }
</style>
@section('content')
    <div class="card">
        <form action="{{ route('refund.update', $refund->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header d-flex">
                <h5 class="modal-title" id="refundDetailModalLabel">Cập nhật trạng thái chi tiết hoàn hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <input type="hidden" name="refund_status" value="{{ $refund->status }}">
                        <div>
                            <strong>Chuyển đổi trạng thái đơn hoàn hàng</strong>
                        </div>
                        <div>
                            <div class="mb-3 mt-3">
                                <h4 class="mb-3 mt-3">Trạng thái hiện tại:
                                    @if ($refund->status == 'PENDING')
                                        <span class="badge bg-primary">Đang chờ xử lý</span>
                                    @elseif ($refund->status === 'APPROVED')
                                        <span class="badge bg-primary">Đã được kiểm duyệt</span>
                                    @elseif ($refund->status === 'IN_TRANSIT')
                                        <span class="badge bg-primary">Đang trong quá trình vận chuyển</span>
                                    @elseif ($refund->status == 'COMPLETED')
                                        <span class="badge bg-primary">Hoàn tất</span>
                                    @endif
                                </h4>
                            </div>

                            <!-- Nút thay đổi trạng thái của đơn hoàn hàng -->
                            @if ($refund->status === 'PENDING')
                                <button type="submit" name="refund_status" value="APPROVED" class="btn btn-warning">Đã
                                    được kiểm duyệt</button>
                            @elseif ($refund->status === 'APPROVED')
                                <button type="submit" name="refund_status" value="IN_TRANSIT" class="btn btn-info">Đang
                                    vận chuyển</button>
                                <button type="submit" name="refund_status" value="COMPLETED" class="btn btn-info">Hoàn
                                    tất</button>
                            @elseif ($refund->status === 'IN_TRANSIT')
                                <button type="submit" name="refund_status" value="COMPLETED" class="btn btn-info">Hoàn
                                    tất</button>
                            @endif

                            <div class="mt-3">
                                <h3 class="text-center">Chi tiết đơn hàng:</h3>
                                <div>
                                    <strong>Mã đơn hàng: </strong>
                                    <span>{{ $refund->order->code ?? 'Không có mã order_id' }}</span>
                                </div>
                                <div>
                                    <strong>Địa chỉ: </strong>
                                    <span>{{ $refund->order->full_address ?? 'Không có địa chỉ' }}</span>
                                </div>
                                <div>
                                    <strong>Khách hàng: </strong>
                                    <span>{{ $refund->order->customer_name }}</span>
                                </div>
                                <div>
                                    <strong>Liên hệ: </strong>
                                    <span>{{ $refund->order->phone }}</span>
                                </div>
                            </div>
                            @foreach ($refund->order->orderItems as $item)
                                <div class="d-flex mt-3 rounded border p-2">
                                    <div class="product-img mr-3">
                                        <a href="{{ route('product', $item->productVariant->product->id) }}">
                                            <img width="100px" height="120px"
                                                src="{{ '/storage/' . $item->productVariant->product->image }}"
                                                alt="{{ $item->productVariant->product->name }}" />
                                        </a>
                                    </div>
                                    <div class="product-bo">
                                        <div>
                                            <strong>Tên sản phẩm: </strong>
                                            <span>{{ $item->product_name }}({{ $item->productVariant->attributeValues->pluck('name')->implode(' - ') }})</span>
                                        </div>
                                        <strong>{{ $item->note }}</strong>
                                        <div>
                                            <strong>Giá sản phẩm: </strong>

                                            <span>{{ number_format($item->product_price, 0, ',', '.') }} VND</span>
                                        </div>
                                        <div>
                                            <strong>Số lượng đã mua trong đơn hàng : </strong>
                                            <span>{{ $item->quantity }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col">
                            <h3 class="text-center">Chi tiết đơn hoàn hàng:</h3>
                            @foreach ($refund->refundItem as $refundItem)
                                <div class="mt-3 rounded border p-2">
                                    <div>
                                        <strong>Sản phẩm hoàn trả:</strong>
                                        <label>{{ $refundItem->productVariant->product->name }}
                                            ({{ $refundItem->productVariant->attributeValues->pluck('name')->implode(' - ') }})
                                        </label>
                                    </div>
                                    <div>
                                        <strong>Số lượng hoàn:</strong>
                                        <label>{{ $refundItem->quantity }}</label>
                                    </div>
                                    <div>
                                        <strong>Lý do hoàn hàng:</strong>
                                        <label>
                                            {{ match ($refundItem->reason) {
                                                'NOT_RECEIVED' => 'Chưa nhận được hàng',
                                                'MISSING_ITEMS' => 'Thiếu sản phẩm',
                                                'DAMAGED_ITEMS' => 'Sản phẩm bị hư hỏng',
                                                'INCORRECT_ITEMS' => 'Sản phẩm không đúng',
                                                'FAULTY_ITEMS' => 'Sản phẩm có lỗi',
                                                'DIFFERENT_FROM_DESCRIPTION' => 'Khác với mô tả',
                                                'USED_ITEMS' => 'Sản phẩm đã qua sử dụng',
                                                default => 'Không xác định',
                                            } }}
                                        </label>
                                    </div>
                                    <div>
                                        <strong>Mô tả chi tiết:</strong>
                                        <label>{{ $refundItem->description }}</label>
                                    </div>
                                    <div>
                                        <img id="smallImg" width="100px" height="120px"
                                            src="{{ '/storage/' . $refundItem->img }}" alt="" onclick="openModal()"
                                            style="cursor: pointer;" />
                                    </div>
                                    <!-- Modal -->
                                    <div id="imgModal" onclick="closeModal()"
                                        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); justify-content: center; align-items: center;">
                                        <span onclick="closeModal()"
                                            style="position: absolute; top: 10px; right: 20px; color: white; font-size: 24px; cursor: pointer;">&times;</span>
                                        <img id="largeImg" src="{{ '/storage/' . $refundItem->img }}"
                                            style="max-width: 80%; max-height: 80%;" onclick="event.stopPropagation();" />
                                    </div>
                                    <div class="mt-2">
                                        <h4 class="mb-3 mt-3">Trạng thái hiện tại:

                                            <!-- Hiển thị trạng thái hiện tại -->
                                            @if ($refundItem->status == 'PENDING')
                                                <span class="badge bg-primary">Chờ phê duyệt</span>
                                            @elseif ($refundItem->status == 'APPROVED')
                                                <span class="badge bg-success">Đã được phê duyệt chấp thuận</span>
                                            @elseif ($refundItem->status == 'REJECTED')
                                                <span class="badge bg-danger">Từ chối hoàn hàng</span>
                                            @endif
                                        </h4>

                                        <!-- Hiển thị nút chọn nếu chưa có trạng thái hoặc trạng thái có thể thay đổi -->
                                        @if ($refundItem->status == 'PENDING')
                                            <button
                                                onclick="return confirm('Bạn có chắc phê duyệt cho đơn hoàn hàng này không ?')"
                                                type="submit" name="statuses[{{ $refundItem->id }}]" value="APPROVED"
                                                class="btn btn-success">Phê duyệt chấp thuận</button>
                                            <button
                                                onclick="return confirm('Bạn có chắc từ chối đơn hoàn hàng này không ?')"
                                                type="submit" name="statuses[{{ $refundItem->id }}]" value="REJECTED"
                                                class="btn btn-danger">Từ chối</button>
                                        @endif
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div>
                    <div class="mt-2">
                        <a href="{{ route('refund.index') }}" class="btn btn-primary">Quay lại</a>
                    </div>
                </div>
        </form>
    </div>
    <script>
        function openModal() {
            const modal = document.getElementById('imgModal');
            modal.style.display = 'flex';
        }

        function closeModal() {
            const modal = document.getElementById('imgModal');
            modal.style.display = 'none';
        }
    </script>
@endsection
