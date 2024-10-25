@extends('admin.layouts.master')

@section('title')
    Thêm mới sản phẩm
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><strong>Thêm mới sản phẩm</strong></div>
        <div class="card-body card-block">
            <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">Mã sản phẩm</label>
                            <input type="text" name="code" id="code" class="form-control"
                                value="{{ old('code') }}" required>
                            @error('code')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ old('description') }}</textarea>
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
                                        {{ old('category_product_id') == $id ? 'selected' : '' }}>{{ $name }}
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
                                <option value="ACTIVE" {{ old('status') == 'ACTIVE' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="IN_ACTIVE" {{ old('status') == 'IN_ACTIVE' ? 'selected' : '' }}>Ngưng hoạt
                                    động</option>
                            </select>
                            @error('status')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Ảnh sản phẩm</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            @error('image')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">Album hình ảnh sản phẩm</label>
                            <input type="file" name="image_url[]" id="image_url" class="form-control" multiple
                                accept="image/*">
                            @error('image_url')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <h3>Thuộc tính sản phẩm:</h3>
                    <div id="attribute-selection">
                        @foreach ($attributes as $attribute)
                            <div class="form-group">
                                <label>{{ $attribute->name }}:</label>
                                <select name="attributes[{{ $attribute->id }}][]" class="form-control attribute-select"
                                    multiple>
                                    @foreach ($attribute->attributeValues as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="generate-variants" class="btn btn-secondary">Tạo biến thể</button>
                    <hr><br>
                    <div id="variants"></div>
                </div>

                <div class="mt-3">
                    <a class="btn btn-primary btn-sm" href="{{ route('products.index') }}">Quay lại</a>
                    <button type="submit" class="btn btn-success btn-sm">Thêm mới</button>
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

            $('#generate-variants').on('click', function() {
                if ($('.attribute-select option:selected').length === 0) {
                    alert('Vui lòng chọn ít nhất một thuộc tính!');
                    return;
                }
                generateVariants();
            });
        });

        function generateVariants() {
            const attributeSelects = document.querySelectorAll('.attribute-select');
            let combinations = [];

            attributeSelects.forEach(select => {
                let selectedValues = Array.from(select.selectedOptions).map(option => ({
                    id: option.value,
                    name: option.text
                }));
                if (selectedValues.length > 0) {
                    combinations.push(selectedValues);
                }
            });

            if (combinations.length === 0) {
                alert('Vui lòng chọn ít nhất một thuộc tính!');
                return;
            }

            const variants = combinations.length === 1 ?
                combinations[0].map(value => [value]) :
                cartesianProduct(combinations);

            const variantsDiv = document.getElementById('variants');
            variantsDiv.innerHTML = '';

            variants.forEach((variant, index) => {
                const variantDiv = document.createElement('div');
                variantDiv.classList.add('variant');
                variantDiv.innerHTML = `
                        <div class="mb-4 border p-3">
                            <h4>Biến thể ${index + 1}</h4>
                            <p>Thuộc tính: ${variant.map(v => v.name).join(', ')}</p>
                            <div class="form-group">
                                <label>Giá:</label>
                                <input type="number" name="variants[${index}][price]" class="form-control" required min=0>
                            </div>
                            <div class="form-group">
                                <label>Số lượng:</label>
                                <input type="number" name="variants[${index}][quantity]" class="form-control" required min=0>
                            </div>
                            ${variant.map(v => `<input type="hidden" name="variants[${index}][attributes][]" value="${v.id}">`).join('')}
                            <div class="text-end">  <!-- Thêm div để căn lề phải -->
                                <button type="button" class="btn btn-danger btn-sm remove-variant">Xóa biến thể</button>
                            </div>
                        </div>
                    `;

                // Thêm sự kiện xóa cho nút xóa
                variantDiv.querySelector('.remove-variant').addEventListener('click', function() {
                    variantDiv.remove();
                });

                variantsDiv.appendChild(variantDiv);
            });
        }

        function cartesianProduct(arr) {
            return arr.reduce((a, b) => a.flatMap(d => b.map(e => [d, e].flat())));
        }
    </script>
@endpush
