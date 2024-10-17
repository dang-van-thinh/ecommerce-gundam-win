@extends('admin.layouts.master')
@section('title')
Trang danh mục sản phẩm
@endsection

@section('content')
<div class="row justify-content-center">
    <!-- Cột 1 -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header text-center">Sửa danh mục sản phẩm</div>
            <div class="card-body card-block">
                <form action="{{ route('categoryproduct.update', $category->id) }}" method="post" enctype="multipart/form-data" class="">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" id="name" name="name" placeholder="{{ $category->name }}" class="form-control"
                                value="{{ old('name', $category->name) }}">
                        </div>
                        <!-- Hiển thị lỗi dưới input -->
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" id="description" name="description" placeholder="{{ $category->description }}"
                                class="form-control" value="{{ old('description', $category->description) }}">
                        </div>
                        <!-- Hiển thị lỗi dưới input -->
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="file" id="image" name="image" class="form-control">
                        </div>
                        <!-- Hiển thị lỗi dưới input -->
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @if ($category->image)
                            <img src="{{ asset('storage/'.$category->image) }}" alt="Category Image" width="100" height="100" class="mt-2">
                        @else
                            <span class="text-danger">No Image</span>
                        @endif
                    </div>

                    <div class="form-actions form-group text-center">
                        <a href="{{ route('categoryproduct.index') }}" class="btn btn-warning btn-sm"><i class="ti-save"></i> Exit</a>
                        <button type="submit" class="btn btn-success btn-sm"><i class="ti-save"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
