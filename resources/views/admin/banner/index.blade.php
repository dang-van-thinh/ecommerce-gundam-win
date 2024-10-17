@extends('admin.layouts.master')



@section('content')

<div class="card">
                    <div class="card-header">
                        <strong class="card-title">Quản lý banner</strong>
                       
                    </div>
                    <div class="d-flex justify-content-end py-3 pe-4">
    <a href="{{ route('banner.create') }}" class="btn btn-success">Thêm mới banner</a>
</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                        <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Ảnh Banner</th>
                                        <th scope="col">Tiêu Đề</th>
                                        <th scope="col">Link Dẫn</th>
                                        <th scope="col">Phân Loại Banner</th>
                                        <th scope="col">Hành Động</th>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                            </svg>
                        </button>

                        <!-- Edit Button -->
                        <a href="{{ route('banner.edit', $banner->id) }}" class="btn btn-warning btn-sm">
                            <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                 width="16" height="16" viewBox="0 0 494.936 494.936" xml:space="preserve">
                                <g>
                                    <g>
                                        <path d="M389.844,182.85c-6.743,0-12.21,5.467-12.21,12.21v222.968c0,23.562-19.174,42.735-42.736,42.735H67.157
                                            c-23.562,0-42.736-19.174-42.736-42.735V150.285c0-23.562,19.174-42.735,42.736-42.735h267.741c6.743,0,12.21-5.467,12.21-12.21
                                            s-5.467-12.21-12.21-12.21H67.157C30.126,83.13,0,113.255,0,150.285v267.743c0,37.029,30.126,67.155,67.157,67.155h267.741
                                            c37.03,0,67.156-30.126,67.156-67.155V195.061C402.054,188.318,396.587,182.85,389.844,182.85z"/>
                                        <path d="M483.876,20.791c-14.72-14.72-38.669-14.714-53.377,0L221.352,229.944c-0.28,0.28-3.434,3.559-4.251,5.396l-28.963,65.069
                                            c-2.057,4.619-1.056,10.027,2.521,13.6c2.337,2.336,5.461,3.576,8.639,3.576c1.675,0,3.362-0.346,4.96-1.057l65.07-28.963
                                            c1.83-0.815,5.114-3.97,5.396-4.25L483.876,74.169c7.131-7.131,11.06-16.61,11.06-26.692
                                            C494.936,37.396,491.007,27.915,483.876,20.791z M466.61,56.897L257.457,266.05c-0.035,0.036-0.055,0.078-0.089,0.107
                                            l-33.989,15.131L238.51,247.3c0.03-0.036,0.071-0.055,0.107-0.09L447.765,38.058c5.038-5.039,13.819-5.033,18.846,0.005
                                            c2.518,2.51,3.905,5.855,3.905,9.414C470.516,51.036,469.127,54.38,466.61,56.897z"/>
                                    </g>
                                </g>
                            </svg>
                        </a>

                        <!-- Delete Form -->
                        <form action="{{ route('banner.destroy', $banner->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa banner này?')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
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
                                <p><strong>Type:</strong> {{ ucfirst($banner->image_type) }}</p>
                                @if ($banner->link)
                                    <p><strong>Link:</strong> <a href="{{ $banner->link }}" target="_blank">{{ $banner->link }}</a></p>
                                @endif
                                <p><strong>Created At:</strong> {{ $banner->created_at->format('d/m/Y') }}</p>
                                <p><strong>Updated At:</strong> {{ $banner->updated_at->format('d/m/Y') }}</p>
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
