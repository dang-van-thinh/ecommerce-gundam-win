
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
                    <label for="title" class="form-label">Tiêu đề ảnh:</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $banners->title) }}" maxlength="255">
                    @error('title')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="image_type" class="form-label">Chọn vị trí hình ảnh:</label>
                    <select id="image_type" name="image_type" class="form-control">
                        <option value="header" {{ old('image_type', $banners->image_type) == 'header' ? 'selected' : '' }}>Header</option>
                        <option value="content" {{ old('image_type', $banners->image_type) == 'content' ? 'selected' : '' }}>Content</option>
                    </select>
                    @error('image_type')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="link" class="form-label">Đường dẫn sản phẩm/ bài viết:</label>
                    <input type="url" id="link" name="link" class="form-control" value="{{ old('link', $banners->link) }}">
                    @error('link')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="image" class="form-label">Chọn ảnh:</label>
                    <input type="file" id="image_file" name="image" class="form-control">
                    @error('image_file')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="image_file">Ảnh:</label> <br>
                    <img src="{{ asset('storage/' . $banners->image_url) }}" class="img-thumbnail" width="600" height="500" alt="Banner Image">
                </div>

            </div>


            <button type="submit" class="btn btn-success">Cập nhật Banner</button>

        </form>
    </div>
</div>



@endsection


@endsection