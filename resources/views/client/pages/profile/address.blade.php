@extends('client.pages.profile.layouts.master')
@section('title')
    Địa chỉ người dùng
@endsection
@section('profile')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="dashboard-right-box">
            <div class="address-tab">
                <div class="sidebar-title">
                    <div class="loader-line"></div>
                    <h4>Địa chỉ người dùng</h4>
                </div>
                <div class="row gy-3">
                @foreach ($addressUsers as $addressUser)
                    <div class="col-xxl-4 col-md-6">
                        <div class="address-option"><label for="address-billing-{{ $addressUser->id }}"> <span class="delivery-address-box"> <span
                                        class="form-check"> <input class="custom-radio" id="address-billing-{{ $addressUser->id }}"
                                            type="radio" name="radio" {{ $addressUser->default  ? 'checked' : '' }}></span><span
                                        class="address-detail"><span class="address"> <span class="address-title">{{ $addressUser->name }}
                                            </span></span><span class="address"> <span class="address-home"> <span
                                                    class="address-tag"> Địa chỉ:</span>
                                                    {{ $addressUser->address_detail }}, {{ $addressUser->ward->name }},
                                                    {{ $addressUser->district->name }}, {{ $addressUser->province->name }}
                                                </span></span> 
                                               <span class="address"> <span
                                                class="address-home"> <span class="address-tag">Số điện thoại :</span>{{ $addressUser->phone }}</span></span></span></span>
                                                <span class="buttons"> 
                                
                                                    <button class="btn btn_black sm"  data-bs-toggle="modal"
                                                        data-bs-target="#edit-box-{{ $addressUser->id }}"  title="Quick View" tabindex="0">
                                                        Chỉnh sửa
                                                    </button>
                                        
                                                    <a class="btn btn_outline sm" href="{{ route('profile.address.destroy', $addressUser->id) }}"  title="Quick View" tabindex="0">Xóa </a>
                                
                                                </span>
                            </label></div>
                                   
                    </div>
                    @include('client.pages.profile.layouts.components.edit-address')
                    
                       @endforeach
                </div>
                
                <button class="btn add-address" data-bs-toggle="modal" data-bs-target="#add-address-modal"
                        title="Quick View" tabindex="0">+ Thêm địa chỉ
                </button>

                @include('client.pages.profile.layouts.components.add-address')
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    
    $(document).ready(function () {
        $('.province').change(function () {
            var provinceId = $(this).val();
            if (provinceId) {
                $.ajax({
                    url: '/get-districts/' + provinceId,
                    type: 'GET',
                    success: function (data) {
                        $('.district').empty().append('<option value="">Chọn Huyện/Quận</option>');
                        $.each(data, function (key, value) {
                            $('.district').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });
        $('.district').change(function () {
            var districtId = $(this).val();
            if (districtId) {
                $.ajax({
                    url: '/get-wards/' + districtId,
                    type: 'GET',
                    success: function (data) {
                        $('.ward').empty().append('<option value="">Chọn Xã/Phường</option>');
                        $.each(data, function (key, value) {
                            $('.ward').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });

 // lay dia chi them moi
        $('#provinceAdd').change(function () {
            var provinceId = $(this).val();
            if (provinceId) {
                $.ajax({
                    url: '/get-districts/' + provinceId,
                    type: 'GET',
                    success: function (data) {
                        $('#districtAdd').empty().append('<option value="">Chọn Huyện/Quận</option>');
                        $('#wardAdd').empty().append('<option value="">Chọn Xã/Phường</option>');
                        $.each(data, function (key, value) {
                            $('#districtAdd').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });
        $('#districtAdd').change(function () {
            var districtId = $(this).val();
            if (districtId) {
                $.ajax({
                    url: '/get-wards/' + districtId,
                    type: 'GET',
                    success: function (data) {
                        $('#wardAdd').empty().append('<option value="">Chọn Xã/Phường</option>');
                        $.each(data, function (key, value) {
                            $('#wardAdd').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });
    });

</script>
