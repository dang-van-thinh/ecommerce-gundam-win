@extends('admin.layouts.master')

@section('title')
    Cập nhật sản phẩm
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><strong>Cập nhật sản phẩm: </strong>{{ $product->name }}</div>
        <div class="card-body card-block">
            <form action="{{ route('products.update', $product) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <!-- Thông tin sản phẩm -->
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

                        <div class="mb-3">
                            <label for="code" class="form-label">Mã sản phẩm</label>
                            <input type="text" name="code" id="code" class="form-control"
                                value="{{ $product->code }}" required>
                            @error('code')
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

                <!-- Biến thể hiện có -->
                <h3>Các biến thể sản phẩm hiện có</h3>
                <div id="existing-variants">
                    @foreach ($product->productVariants as $index => $variant)
                        <div class="variant mb-4 border p-3">
                            <h4>Biến thể {{ $index + 1 }}</h4>
                            <div class="mt-2">
                                <strong>Thuộc tính:</strong> {{ $variant->attributeValues->pluck('name')->implode(', ') }}
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
                            <input type="hidden" class="existing-variant-attributes"
                                value="{{ $variant->attributeValues->pluck('id')->implode('-') }}">

                            <!-- Nút xoá biến thể -->
                            <div class="text-end">
                                <button type="button" class="btn btn-danger btn-sm remove-variant"
                                    data-variant-id="{{ $variant->id }}">Xoá biến thể
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Thuộc tính để tạo biến thể mới -->
                <div class="col-12">
                    <h3>Thêm biến thể sản phẩm mới</h3>
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

                    <button type="button" id="generate-variants" class="btn btn-secondary">Tạo biến thể mới</button>
                    <hr>
                    <div id="new-variants"></div>
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

            $('#generate-variants').on('click', function() {
                generateVariants();
            });

            $(document).on('click', '.remove-variant', function() {
                const variantId = $(this).data('variant-id');
                $(this).closest('.variant').hide();
                $('<input>').attr({
                    type: 'hidden',
                    name: 'delete_variants[]',
                    value: variantId
                }).appendTo('form');
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

            // Kiểm tra xem có tồn tại biến thể hiện có nào không
            const existingAttributes = document.querySelectorAll('.existing-variant-attributes');
            const existingAttributesCount = existingAttributes.length > 0 ?
                existingAttributes[0].value.split('-').length :
                0;

            if (existingAttributesCount > 0 && combinations.length !== existingAttributesCount) {
                alert('Số lượng thuộc tính mới không khớp với các biến thể hiện có. Vui lòng chọn lại.');
                return;
            }

            if (combinations.length === 0) {
                alert('Vui lòng chọn ít nhất một thuộc tính!');
                return;
            }

            const variants = combinations.length === 1 ?
                combinations[0].map(value => [value]) :
                cartesianProduct(combinations);

            const variantsDiv = document.getElementById('new-variants');
            variantsDiv.innerHTML = '';

            variants.forEach((variant, index) => {
                const attributeIds = variant.map(v => v.id).sort().join('-');
                const existingVariants = Array.from(existingAttributes).map(input => input.value);

                if (!existingVariants.includes(attributeIds)) {
                    const variantIndex = document.querySelectorAll('.variant').length;
                    const variantDiv = document.createElement('div');
                    variantDiv.classList.add('variant', 'border', 'p-3', 'position-relative');

                    variantDiv.innerHTML = `
                                <div class="position-relative">
                                    <div class="d-flex justify-content-between">
                                        <h4>Biến thể mới ${variantIndex + 1}</h4>
                                    </div>
                                    <p>Thuộc tính: ${variant.map(v => v.name).join(', ')}</p>
                                    <div class="form-group">
                                        <label>Giá:</label>
                                        <input type="number" name="new_variants[${variantIndex}][price]" class="form-control" required min="0">
                                    </div>
                                    <div class="form-group">
                                        <label>Số lượng:</label>
                                        <input type="number" name="new_variants[${variantIndex}][quantity]" class="form-control" required min="0">
                                    </div>
                                    ${variant.map(v => `<input type="hidden" name="new_variants[${variantIndex}][attributes][]" value="${v.id}">`).join('')}

                                    <div class="text-end"> 
                                        <button type="button" class="btn btn-danger btn-sm remove-variant">Xóa biến thể</button>
                                    </div>
                                </div>
                            `;

                    variantsDiv.appendChild(variantDiv);
                } else {
                    const attributeNames = variant.map(v => v.name).join(', ');
                    alert(`Biến thể với thuộc tính ${attributeNames} đã tồn tại.`);
                }
            });

            // Gán sự kiện cho nút "Xoá" của các biến thể mới
            $(document).on('click', '.remove-new-variant', function() {
                $(this).closest('.variant').remove();
            });
        }


        function cartesianProduct(arr) {
            return arr.reduce((a, b) => a.flatMap(d => b.map(e => [d, e].flat())));
        }
    </script>
@endpush
