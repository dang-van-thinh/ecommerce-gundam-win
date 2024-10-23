@extends('admin.layouts.master')

@section('title', 'Quản lí Banner')

@section('content')
<style>
td {
  white-space: nowrap;     /* Keep text on one line */
  overflow: hidden;        /* Hide overflowed content */
  text-overflow: ellipsis; /* Show '...' for clipped text */
  max-width: 200px;        /* Set a maximum width for the text */
}
</style>

<div class="card">
    <div class="card-header">
        <strong class="card-title">Quản lý banner</strong>

    </div>
    <div class="d-flex justify-content-end py-3 pe-4">
        <a href="{{ route('banner.create') }}" class="btn btn-success">Thêm mới banner</a>
    </div>
    <div class="card-body">
        <table style="table-layout: fixed; width: 100%;" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col" width= "5px">#</th>
                    <th scope="col" width= "40px">Ảnh Banner</th>
                    <th scope="col" width= "30px"  style="text-overflow: ellipsis;">Tiêu Đề</th>
                    <th scope="col" width="120px">Link Dẫn</th>
                    <th scope="col" width= "40px">Phân Loại Banner</th>
                    <th scope="col" width= "40px">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banners as $index => $banner)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $banner->image_url) }}" class="img-thumbnail" width="100" height="50" alt="Banner Image">
                    </td>
                    <td>{{ $banner->title }}</td>
                    <td><a href="{{ $banner->link }}" target="_blank">{{ $banner->link }}</a></td>
                    <td>{{ ucfirst($banner->image_type) }}</td>
                    <td>
                        <!-- Info Button to Trigger Modal -->
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bannerModal{{ $banner->id }}">
                        <i class="fa fa-info-circle"></i>
                        </button>

                        <!-- Edit Button -->
                        <a href="{{ route('banner.edit', $banner->id) }}" class="btn btn-warning btn-sm">
                        <i class="fa fa-pencil-square-o"></i>
                        </a>

                        <!-- Delete Form -->
                        <form action="{{ route('banner.destroy', $banner->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa banner này?')">
                            <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Modal for Showing Banner Details -->
                <div class="modal fade" id="bannerModal{{ $banner->id }}" tabindex="-1" aria-labelledby="bannerModalLabel{{ $banner->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-bettween">
                                <h4 class="modal-title" id="bannerModalLabel{{ $banner->id }}">Chi tiết banner</h4>
                                <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>

                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-4"><img src="{{ asset('storage/' . $banner->image_url) }}" class="img-fluid mb-3" alt="{{ $banner->title }}"></div>
                                    <div class="col-8">

                                        <p><strong>Tiêu đề:</strong> {{ $banner->title }}</p>
                                        <p><strong>Vị trí banner:</strong> {{ ucfirst($banner->image_type) }}</p>
                                        @if ($banner->link)
                                        <p><strong>Đường dẫn đến bài viết/ sản phẩm:</strong> <a href="{{ $banner->link }}" target="_blank">{{ $banner->link }}</a></p>
                                        @endif
                                        <p><strong>Được tạo:</strong> {{ $banner->created_at->format('d/m/Y') }}</p>
                                        <p><strong>Cập nhật:</strong> {{ $banner->updated_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection