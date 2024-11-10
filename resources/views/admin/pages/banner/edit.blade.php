
@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa Banner')

@section('content')



@section('content')
<div class="card">
    <div class="card-header ">Chỉnh sửa Banner</div>
    <div class="card-body card-block">
        <form action="{{ route('banner.update', $banners->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="title" class="form-label">Tiêu đề ảnh:</label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ $banners->title }}" maxlength="255">
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col-md-12">
                            <label for="image_type" class="form-label">Chọn vị trí hình ảnh:</label>
                            <select id="image_type" name="image_type" class="form-control">
                                <option value="HEADER" {{ $banners->image_type == 'HEADER' ? 'selected' : '' }}>Header</option>
                                <option value="CONTENT-LEFT-TOP" {{ $banners->image_type == 'CONTENT-LEFT-TOP' ? 'selected' : '' }}>Content-left-top</option>
                                <option value="CONTENT-LEFT-BELOW" {{ $banners->image_type == 'CONTENT-LEFT-BELOW' ? 'selected' : '' }}>Content-left-right</option>
                                <option value="CONTENT-RIGHT" {{ $banners->image_type == 'CONTENT-RIGHT' ? 'selected' : '' }}>Content-right</option>
                                <option value="SUBSCRIBE-NOW-EMAIL" {{ $banners->image_type == 'SUBSCRIBE-NOW-EMAIL' ? 'selected' : '' }}>subscribe-now-email</option>
                                <option value="BANNER-LEFT" {{ $banners->image_type == 'BANNER-LEFT' ? 'selected' : '' }}>banner-left</option>
                                <option value="BANNER-RIGHT" {{ $banners->image_type == 'BANNER-RIGHT' ? 'selected' : '' }}>banner-right</option>
                                </select>
                            @error('image_type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="link" class="form-label">Đường dẫn sản phẩm/ bài viết:</label>
                            <input type="url" id="link" name="link" class="form-control" value="{{ $banners->link }}">
                            @error('link')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="image" class="form-label">Chọn ảnh:</label>
                            <input type="file" id="image_file" name="image" class="form-control">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="image_file">Ảnh:</label> <br>
                            <img src="{{ asset('storage/' . $banners->image_url) }}" class="img-thumbnail" width="600" height="500" alt="Banner Image">
                        </div>
        
                    </div>
                 
                </div>
                <div class="col-md-6">
                    <h4>Ghi chú:</h4> <br>
                    <p>HEADER yêu cầu kích thước tối đa 1600x650</p>
                    <p>CONTENT-LEFT-TOP yêu cầu 650x300</p>
                    <p>CONTENT-LEFT-BELOW yêu cầu 650x300</p>
                    <p>CONTENT-RIGHT yêu cầu 500x550</p>
                    <p>SUBSCRIBE-NOW-EMAIL yêu cầu 1100x700</p>
                    <p>BANNER-LEFT yêu cầu 700x700</p>
                    <p>BANNER-RIGHT yêu cầu 700x500</p>

                </div>
            </div>
           

            <button type="submit" class="btn btn-success">Cập nhật Banner</button>

        </form>
    </div>
</div>



@endsection


@endsection