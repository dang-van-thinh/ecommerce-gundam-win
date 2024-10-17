{{-- resources/views/admin/banner/edit.blade.php --}}
@extends('admin.layouts.master')

@section('title', 'Edit Banner')

@section('content')
<div class="container">
    <h1>Edit Banner</h1>

    <form action="{{ route('banner.update', $banners->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Tiêu đề</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $banners->title) }}" maxlength="255">
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="image_file">Ảnh</label> <br>
            <img src="{{ asset('storage/' . $banners->image_url) }}" class="img-thumbnail" width="500" height="400" alt="Banner Image">
        </div>

        <div class="form-group">
            <label for="image_file">Upload Image</label>
            <input type="file" id="image_file" name="image" class="form-control" >
            @error('image_file')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image_type">Vị trí banner</label>
            <select id="image_type" name="image_type" class="form-control">
                <option value="header" {{ old('image_type', $banners->image_type) == 'header' ? 'selected' : '' }}>Header</option>
                <option value="content" {{ old('image_type', $banners->image_type) == 'content' ? 'selected' : '' }}>Content</option>
            </select>
            @error('image_type')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="link">Link đường dẫn sản phẩm/ bài viết</label>
            <input type="url" id="link" name="link" class="form-control" value="{{ old('link', $banners->link) }}">
            @error('link')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Cập nhật Banner</button>
    </form>
</div>
@endsection
