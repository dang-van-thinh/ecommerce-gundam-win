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
                            <input type="file" name="image" id="image" class="form-control" accept="image/*"
                                required>
                            @error('image')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">Album hình ảnh sản phẩm</label>
                            <input type="file" name="image_url[]" id="image_url" class="form-control" multiple
                                accept="image/*" required>
                            @error('image_url')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <h3>Tạo sản phẩm biến thể</h3><br>
                    <div class="d-flex">
                        <button type="button" id="generate-auto" class="btn btn-secondary btn-sm">Tạo tự động</button>
                        <button type="button" id="add-variant" class="btn btn-secondary btn-sm mx-1">Tạo thủ công</button>
                        <button type="button" id="check-duplicates" class="btn btn-warning btn-sm">Check Trùng Lặp</button>
                    </div>

                    <hr>

                    <div id="variants"></div>
                </div>
                <div>
                    <div id="auto-attribute-selection" style="display: none;" class="col-12">
                        <h4>Chọn giá trị thuộc tính để tạo biến thể:</h4><br>
                        <div >
                            @foreach ($attributes as $attribute)
                                <div class="form-group me-2">
                                    <label>Size</label>

                                    <select multiple name="auto_attributes[{{ $attribute->id }}][]"
                                        class="form-control auto-attribute-select"
                                        data-attribute-id="{{ $attribute->id }}">
                                        @foreach ($attribute->attributeValues as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>

                                    <button type="button" class="select-all btn btn-primary btn-sm">Chọn tất cả</button>
                                    <button type="button" class="deselect-all btn btn-secondary btn-sm">Bỏ tất cả</button>

                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="create-variants" class="btn btn-success mt-2">Tạo</button>
                        <hr>
                    </div>
                </div>

                <div class="mt-3">
                    <a class="btn btn-primary" href="{{ route('products.index') }}">Quay lại</a>
                    <button type="submit" class="btn btn-success ">Thêm mới</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('admin-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#description').summernote({
                height: 300
            });

            $(".auto-attribute-select").select2({
                tags: true,
                tokenSeparators: [',', ' '],
                width: '100%' // Đảm bảo Select2 sử dụng toàn bộ chiều rộng
            });

            // Sự kiện cho nút "Chọn tất cả"
            $('.select-all').on('click', function() {
                const select = $(this).siblings('.auto-attribute-select'); // Lấy select bên cạnh nút
                select.find('option').prop('selected', true); // Chọn tất cả
                select.trigger('change'); // Cập nhật Select2
            });

            // Sự kiện cho nút "Bỏ tất cả"
            $('.deselect-all').on('click', function() {
                const select = $(this).siblings('.auto-attribute-select'); // Lấy select bên cạnh nút
                select.find('option').prop('selected', false); // Bỏ chọn tất cả
                select.trigger('change'); // Cập nhật Select2
            });


            const variantCombinations = new Set();

            $('#add-variant').on('click', function() {
                const variantDiv = addVariant();
                if (variantDiv) {
                    $('#variants').append(variantDiv);
                }
            });

            $('#generate-auto').on('click', function() {
                $('#auto-attribute-selection').toggle(); // Hiện hoặc ẩn phần chọn thuộc tính
            });

            $('#create-variants').on('click', function() {
                const selectedAttributes = {};
                $('.auto-attribute-select').each(function() {
                    const attributeId = $(this).data('attribute-id');
                    const selectedValues = $(this).val();
                    if (selectedValues && selectedValues.length) {
                        selectedAttributes[attributeId] = selectedValues;
                    }
                });

                if (Object.keys(selectedAttributes).length === 0) {
                    alert("Vui lòng chọn ít nhất một giá trị thuộc tính.");
                    return;
                }

                const combinations = generateCombinations(Object.values(selectedAttributes));

                combinations.forEach((combination, index) => {
                    const variantDiv = addVariant(index, combination);
                    if (variantDiv) {
                        $('#variants').append(variantDiv);
                    }
                });

                $('#auto-attribute-selection').hide(); // Ẩn phần chọn thuộc tính sau khi tạo biến thể
            });

            function generateCombinations(arr) {
                return arr.reduce((a, b) => a.flatMap(d => b.map(e => [...d, e])), [
                    []
                ]);
            }

            function addVariant(index = $('.variant').length, attributes = []) {
                const variantDiv = $(`
                    <div class="variant mb-4 border p-3">
                        <h4>Biến thể ${index + 1}</h4><br>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-wrap">
                                <strong class="mr-3">Thuộc tính:</strong>
                                @foreach ($attributes as $attribute)
                                    <div class="form-group d-flex align-items-center me-1">
                                        <select name="variants[${index}][attributes][{{ $attribute->id }}]"
                                            class="form-control variant-select" data-attribute-id="{{ $attribute->id }}" required>
                                            <option value="">Chọn {{ $attribute->name }}</option>
                                            @foreach ($attribute->attributeValues as $value)
                                                <option value="{{ $value->id }}" ${attributes.includes('{{ $value->id }}') ? 'selected' : ''}>{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-info btn-sm toggle-variant-info">Ẩn/Hiện thông tin</button>
                                <button type="button" class="btn btn-danger btn-sm remove-variant">Xóa biến thể</button>
                            </div>
                        </div>
                        <div class="variant-info" style="display:none;">
                            <div class="form-group">
                                <label>Giá:</label>
                                <input type="number" name="variants[${index}][price]" class="form-control" required min="0">
                            </div>
                            <div class="form-group">
                                <label>Số lượng:</label>
                                <input type="number" name="variants[${index}][quantity]" class="form-control" required min="0">
                            </div>
                        </div>
                    </div>
                `);

                // Lắng nghe sự kiện cho nút ẩn hiện
                variantDiv.find('.toggle-variant-info').on('click', function() {
                    $(this).closest('.variant').find('.variant-info').toggle();
                });

                return variantDiv;
            }

            $('#variants').on('click', '.remove-variant', function() {
                $(this).closest('.variant').remove(); // Xóa biến thể
            });

            $('#check-duplicates').on('click', function() {
                const variants = []; // Mảng lưu trữ các biến thể để kiểm tra trùng lặp
                const duplicateVariants = []; // Mảng lưu trữ thông tin các biến thể trùng lặp

                // Duyệt qua tất cả các biến thể
                $('.variant').each(function(index) {
                    const attributes = [];

                    // Duyệt qua tất cả các thuộc tính của biến thể
                    $(this).find('.variant-select').each(function() {
                        const attributeId = $(this).data('attribute-id');
                        const valueId = $(this).val();
                        attributes.push({
                            attributeId,
                            valueId
                        });
                    });

                    // Chuỗi JSON của tổ hợp thuộc tính cho biến thể
                    const attributesString = JSON.stringify(attributes);

                    // Kiểm tra nếu biến thể đã tồn tại trong mảng
                    const duplicateIndex = variants.indexOf(attributesString);
                    if (duplicateIndex !== -1) {
                        // Nếu trùng lặp, lưu lại thông tin biến thể bị trùng
                        duplicateVariants.push({
                            current: index + 1, // Vị trí của biến thể hiện tại
                            duplicateWith: duplicateIndex + 1 // Vị trí của biến thể trùng
                        });
                    } else {
                        // Nếu không trùng lặp, thêm tổ hợp thuộc tính vào mảng
                        variants.push(attributesString);
                    }
                });

                // Hiển thị thông báo
                if (duplicateVariants.length > 0) {
                    let message = 'Các biến thể sau bị trùng lặp:\n';
                    duplicateVariants.forEach(dup => {
                        message +=
                            `- Biến thể ${dup.current} trùng với biến thể ${dup.duplicateWith}\n`;
                    });
                    alert(message);
                } else {
                    alert('Không có biến thể nào bị trùng lặp.');
                }
            });

        });
    </script>
@endpush
