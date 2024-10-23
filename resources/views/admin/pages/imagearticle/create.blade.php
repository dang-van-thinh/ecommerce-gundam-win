@extends('admin.layouts.master')
@section('title')
    Thêm mới hình ảnh
@endsection
@section('content')
    <div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Thêm mới hình ảnh</strong>
                </div>
                <div class="card-body card-block">
                    <form action="{{ route('imagearticle.store') }}" method="post" enctype="multipart/form-data"
                        class="form-horizontal">
                        @csrf
                        <!-- Upload ảnh -->
                        <div class="row form-group">
                            <div class="col col-md-2">
                                <label for="images" class="form-control-label">Ảnh đại bài viết</label>
                            </div>
                            <div class="col-12 col-md-8">
                                <input type="file" id="images" name="images[]" class="form-control" multiple>
                                @error('images')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Nút Submit -->
                        <div class="form-actions form-group">
                            <a href="{{ route('imagearticle.index') }}" class="btn btn-primary btn-sm">Quay lại</a>
                            <button type="submit" class="btn btn-success btn-sm">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
