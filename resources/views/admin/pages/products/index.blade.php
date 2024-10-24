@extends('admin.layouts.master')

@section('title')
    Danh sách sản phẩm
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <strong class="card-title"> Danh sách sản phẩm</strong>
        </div>

        <div class="card-body">
            <div class="text-end mb-3">
                <a class="btn btn-success" href="{{ route('products.create') }}">Thêm mới</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $product)
                            <tr class="">
                                <td scope="row">{{ $product->id }}</td>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ '/storage/' . $product->image }}" alt="" width="50px">
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    @if ($product->status == 'ACTIVE')
                                        <span class="badge bg-primary">Hoạt động</span>
                                    @else
                                        <span class="badge bg-secondary">Ngưng hoạt động!</span>
                                    @endif
                                </td>
                                
                                <td>{{ $product->categoryProduct->name }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">

                                        <div class="mr-1">
                                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <form action="{{ route('products.destroy', $product) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Có chắc chắn muốn xóa không?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            {{ $data->links() }}
        </div>
    </div>
@endsection
