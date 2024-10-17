@extends('admin.layouts.master')

@section('title', 'Thêm mới Banner')

@section('content')
    <h1 class="mb-4">Thêm mới Banner</h1>

    <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf

        <div class="col-md-6">
            <label for="title" class="form-label">Tiêu đề ảnh:</label>
            <input type="text" name="title" class="form-control" placeholder="Title" >
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="image" class="form-label">Chọn ảnh:</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="image_type" class="form-label">Chọn vị trí hình ảnh:</label>
            <select name="image_type" class="form-select" required>
                <option value="header">Header</option>
                <option value="content">Content</option>
            </select>
            @error('image_type')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="link" class="form-label">Đường dẫn sản phẩm/ bài viết:</label>
            <input type="url" name="link" class="form-control" placeholder="Link">
            @error('link')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary mt-3">Thêm mới</button>
        </div>
    </form>
@endsection
