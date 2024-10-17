@extends('admin.layouts.master')
@section('title')
Trang danh mục sản phẩm
@endsection
@section('content')
<div class="row">
    <!-- Cột 1 -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Thêm danh mục sản phẩm</div>
            <div class="card-body card-block">
                <form action="{{route('categoryproduct.store')}}" method="post" enctype="multipart/form-data" class="">
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" id="name" name="name" placeholder="Tên danh mục" class="form-control"
                                value="{{ old('name') }}">
                        </div>
                        <!-- Hiển thị lỗi dưới input -->
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" id="description" name="description" value="{{ old('description') }}"
                                placeholder="Mô tả" class="form-control">
                        </div>
                        <!-- Hiển thị lỗi dưới input -->
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="file" id="image" name="image"  placeholder="Hình ảnh"
                                class="form-control">
                        </div>
                        @if (old('image'))
                            <input type="hidden" name="old_image" value="{{ old('image') }}">
                        @endif
                        <!-- Hiển thị lỗi dưới input -->
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions form-group">
                        <button type="submit" class="btn btn-success btn-sm"><i class="ti-save"></i> Submit</button>
                    </div>
            </div>
            </form>
        </div>
    </div>

    <!-- Cột 2 -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Danh mục sản phẩm</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Tên</th>
                            <th scope="col" class="text-center">Mô tả</th>
                            <th scope="col" class="text-center">Hình ảnh</th>
                            <th scope="col" class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listCateProduct as $index => $list)
                            <tr>
                                <th scope="row" class="text-center">{{$index + 1}}</th>
                                <td class="text-center">{{$list->name}}</td>
                                <td class="text-center">{{$list->description}}</td>
                                <td class="text-center">
                                    @if ($list->image)
                                        <img src="{{ asset('storage/'.$list->image) }}" alt="Category Image" width="100" height="100">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('categoryproduct.edit', $list->id) }}" class="btn btn-warning"><i
                                            class="ti-slice"></i></a>
                                    <form action="{{ route('categoryproduct.destroy', $list->id) }}" method="POST"
                                        style="display:inline;" id="delete-form-{{ $list->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger"
                                            onclick="confirmDelete({{ $list->id }})">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </form>

                                    <script>
                                        function confirmDelete(id) {
                                            Swal.fire({
                                                title: 'Bạn có chắc chắn muốn xóa không?',
                                                text: "Hành động này sẽ không thể hoàn tác!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonText: 'Có !',
                                                cancelButtonText: 'Không !'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    // Nếu xác nhận, gửi form
                                                    document.getElementById('delete-form-' + id).submit();
                                                }
                                            });
                                        }
                                    </script>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$listCateProduct->links()}}
            </div>
        </div>
    </div>

</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
    <script type="text/javascript">
        Swal.fire({
            title: 'Thành công!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK',
            position: 'center'
        });
    </script>
@endif
