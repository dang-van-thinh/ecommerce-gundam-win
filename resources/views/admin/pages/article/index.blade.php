@extends('admin.layouts.master')
@section('title')
    Danh sách bài viết
@endsection
@section('content')
    <div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Danh sách sản phẩm</strong>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tile</th>
                                <th scope="col">Image</th>
                                <th scope="col">Content</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div style="text-align: right;">
                                <a href="{{ route('article.create') }}" class="btn btn-success">Thêm mới</a>
                            </div>
                            <br>
                            @foreach ($listArticle as $index => $list)
                                <tr>
                                    <th scope="row" class="text-center">{{ $index + 1 }}</th>
                                    <td class="text-center">{{ $list->title }}</td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/' . $list->image) }}" alt="" width="100px"
                                            height="100px">
                                    </td>
                                    <td class="text-center">{{ $list->content }}</td>

                                    <td class="text-center">
                                        <a href="{{ route('article.edit', $list->id) }}" class="btn btn-warning">
                                            <i class="fa fa-pencil"></i></a>
                                        <form action="{{ route('article.destroy', $list->id) }}" method="POST"
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
                </div>
            </div>
        </div>
    </div>
@endsection
