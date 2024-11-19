@extends('admin.layouts.master')
@section('title')
    Phiếu Giảm Giá
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Danh sách phiếu giảm giá</strong>
        </div>
        <div class="d-flex justify-content-end mx-3 mt-4">
            <a href="{{ route('voucher.create') }}" class="btn btn-success me-2 px-4">
                Thêm mới
            </a>
        </div>
        <div class="card-body">
            <table class="table-bordered table">
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Tên voucher</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Loại voucher</th>
                        <th scope="col">Giá trị giảm</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Số lần đã sử dụng</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($getAllVoucher as $voucher)
                        <tr class="text-center">
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $voucher->name }}</td>
                            <td>{{ $voucher->limit }}</td>
                            <td>
                                @if ($voucher->type === 'OTHER')
                                    Khác
                                @elseif($voucher->type === 'REGISTER')
                                    Áp dụng khách hàng mới
                                @elseif($voucher->type === 'SUCCESS')
                                    Áp dụng khách hàng mua hàng
                                @endif
                            </td>
                            <td>
                                @if ($voucher->discount_type === 'PERCENTAGE')
                                    {{ number_format($voucher->discount_value, 0) }}%
                                @endif

                                @if ($voucher->discount_type === 'FIXED')
                                    {{ number_format($voucher->discount_value, 0, ',', '.') }} VND
                                @endif
                            </td>
                            <td>
                                @if ($voucher->status === 'ACTIVE')
                                    Hoạt động
                                @elseif($voucher->status === 'IN_ACTIVE')
                                    Không hoạt động
                                @endif
                            </td>
                            <td>{{ $voucher->voucher_used }}</td>
                            <td class="d-flex justify-content-center">
                                <div class="me-2">
                                    <form action="{{ route('voucher.destroy', $voucher->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger"
                                            onclick="return confirm('Bạn có chắc muốn xóa mã giảm giá này không ?')">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="me-2">
                                    <a href="{{ route('voucher.edit', $voucher->id) }}" class="btn btn-warning">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#voucherDetailModal-{{ $voucher->id }}">
                                        <i class="fa fa-info-circle"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @include('admin.pages.voucher.show')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        {{ $getAllVoucher->links() }}
    </div>
@endsection
