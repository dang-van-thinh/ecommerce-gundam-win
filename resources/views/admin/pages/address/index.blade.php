@extends('admin.layouts.master')
@section('title')
Trang danh sách địa chỉ
@endsection
@section('content')
<div class="col-xs-6 col-sm-6">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Địa chỉ</strong>
        </div>
        <div class="card-body">
            <form action="">
                <!-- Tỉnh/Thành phố -->
                <div class="form-group">
                    <label for="province">Chọn Tỉnh/Thành phố</label>
                    <select class="form-control" id="province" name="province"
                        data-placeholder="Chọn Tỉnh/Thành phố...">
                        <option value="">Chọn Tỉnh/Thành phố</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Huyện/Quận -->
                <div class="form-group">
                    <label for="district">Chọn Huyện/Quận</label>
                    <select class="form-control" id="district" name="district">
                        <option value="">Chọn Huyện/Quận</option>
                    </select>
                </div>
                <!-- Xã/Phường -->
                <div class="form-group">
                    <label for="ward">Chọn Xã/Phường</label>
                    <select class="form-control" id="ward" name="ward">
                        <option value="">Chọn Xã/Phường</option>
                    </select>
                </div>
                <!-- nhập địa chỉ  -->
                <div class="form-group">
                    <label for="ward">Nhập địa chỉ chi tiết</label>
                    <input class="form-control" type="text" placeholder="Nhập địa chỉ">
                </div>
                <div class="d-flex justify-content-center align-items-center" style="height: 50px;">
                    <button type="submit" class="btn btn-success">Thêm mới</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
@push('admin-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#province').change(function () {
                var provinceId = $(this).val();
                if (provinceId) {
                    $.ajax({
                        url: '/get-districts/' + provinceId,
                        type: 'GET',
                        success: function (data) {
                            $('#district').empty().append('<option value="">Chọn Huyện/Quận</option>');
                            $('#ward').empty().append('<option value="">Chọn Xã/Phường</option>');
                            $.each(data, function (key, value) {
                                $('#district').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });
            // Khi người dùng chọn huyện
            $('#district').change(function () {
                var districtId = $(this).val();
                if (districtId) {
                    $.ajax({
                        url: '/get-wards/' + districtId,
                        type: 'GET',
                        success: function (data) {
                            $('#ward').empty().append('<option value="">Chọn Xã/Phường</option>');
                            $.each(data, function (key, value) {
                                $('#ward').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
