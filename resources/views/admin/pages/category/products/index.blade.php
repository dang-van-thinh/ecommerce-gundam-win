@extends('admin.layouts.master')
@section('title')
Danh mục sản phẩm
@endsection
@section('content')
<div class="row">
    <!-- Cột 1 -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Thêm danh mục sản phẩm</div>
            <div class="card-body card-block">
                <form action="{{route('category-product.store')}}" method="post" enctype="multipart/form-data" class="">
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" id="name" name="name" placeholder="Tên danh mục" class="form-control"
                                value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" id="description" name="description" value="{{ old('description') }}"
                                placeholder="Mô tả" class="form-control">
                        </div>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="file" id="image" name="image" placeholder="Hình ảnh" class="form-control">
                        </div>
                        @if (old('image'))
                            <input type="hidden" name="old_image" value="{{ old('image') }}">
                        @endif
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-actions form-group">
                        <button type="submit" class="btn btn-success btn-sm"> Thêm mới</button>
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
                                        <img src="{{ asset('storage/' . $list->image) }}" alt="Category Image" width="100"
                                            height="100">
                                    @else
                                        <span>Không có ảnh</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('category-product.edit', $list->id) }}" class="btn btn-warning"><i
                                            class="ti-slice"></i></a>
                                    <form action="{{ route('category-product.destroy', $list->id) }}" method="POST"
                                        style="display:inline;" id="delete-form-{{ $list->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?') ? document.getElementById('delete-form-{{ $list->id }}').submit() : false;">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </form>
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
