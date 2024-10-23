@extends('admin.layouts.master')

@section('title')
    Cập nhật sản phẩm
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><strong>Cập nhật sản phẩm</strong></div>
        <div class="card-body card-block">
            <form action="{{ route('products.update', $product) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row">
                    <div class="col-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $product->name }}" required>
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ $product->description }}</textarea>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-3">
                            <label for="category_product_id" class="form-label">Danh mục sản phẩm</label>
                            <select name="category_product_id" id="category_product_id" class="form-control" required>
                                @foreach ($categoryProduct as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ $product->category_product_id == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_product_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status">
                                <option value="ACTIVE" {{ $product->status == 'ACTIVE' ? 'selected' : '' }}>Hoạt động
                                </option>
                                <option value="IN_ACTIVE" {{ $product->status == 'IN_ACTIVE' ? 'selected' : '' }}>Ngưng
                                    hoạt động</option>
                            </select>
                            @error('status')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Ảnh sản phẩm</label>
                            <input type="file" name="image" id="image" class="form-control mb-1" accept="image/*">
                            @if ($product->image)
                                <img src="{{ '/storage/' . $product->image }}" alt="" width="100px">
                            @endif
                            @error('image')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">Album hình ảnh sản phẩm</label>
                            <input type="file" name="image_url[]" id="image_url" class="form-control" multiple
                                accept="image/*">
                            @foreach ($product->productImages as $image)
                                <img src="{{ '/storage/' . $image->image_url }}" alt="" width="70px">
                            @endforeach
                            @error('image_url')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>
                <h3>Cập nhật biến thể sản phẩm</h3>
                <div id="variants">
                    @foreach ($product->productVariants as $index => $variant)
                        <div class="variant mb-4 border p-3">
                            <h4>Biến thể {{ $index + 1 }}</h4>
                            <div class="mt-2">
                                <strong>Thuộc tính:</strong>
                                {{ $variant->attributeValues->pluck('name')->implode(', ') }}
                            </div>
                            <div class="form-group mb-2">
                                <label>Giá:</label>
                                <input type="number" name="variants[{{ $variant->id }}][price]" class="form-control"
                                    value="{{ $variant->price }}" required min="0">
                            </div>
                            <div class="form-group mb-2">
                                <label>Số lượng:</label>
                                <input type="number" name="variants[{{ $variant->id }}][quantity]" class="form-control"
                                    value="{{ $variant->quantity }}" required min="0">
                            </div>
                            <input type="hidden" name="variants[{{ $variant->id }}][id]" value="{{ $variant->id }}">
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    <a class="btn btn-primary btn-sm" href="{{ route('products.index') }}">Quay lại</a>
                    <button type="submit" class="btn btn-success btn-sm">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('admin-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#description').summernote({
                height: 300,
            });
        });
    </script>
@endpush
