@extends('admin.layouts.master')

@section('title', 'Thêm mới Banner')

@section('content')
<div class="card">
    <div class="card-header ">Thêm mới Banner</div>
    <div class="card-body card-block">
        <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <label for="title" class="form-label">Tiêu đề ảnh:</label>
                    <input type="text" name="title" class="form-control" 
                    placeholder="Tiêu đề ảnh" value="{{ old('title') }}" >
                    @error('title')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="image" class="form-label">Chọn ảnh:</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    @if (old('image'))
            <input type="hidden" name="old_image" value="{{ old('image') }}">
                    @endif
                    @error('image')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="image_type" class="form-label">Chọn vị trí hình ảnh:</label>
                    <select name="image_type" class="form-select">
                    <option value="header" {{ old('image_type') == 'header' ? 'selected' : '' }}>Header</option>
                    <option value="content" {{ old('image_type') == 'content' ? 'selected' : '' }}>Content</option>
                    </select>
                    @error('image_type')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="link" class="form-label">Đường dẫn sản phẩm/ bài viết:</label>
                    <input type="url" name="link" class="form-control" placeholder="Link" value="{{ old('link') }}">
                    @error('link')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary mt-3">Thêm mới</button>
                <a href="{{ route('banner.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
            </div>
        </form>
    </div>
</div>



@endsection