<div class="modal fade" id="imageDetailModal" tabindex="-1" role="dialog" aria-labelledby="imageDetailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex">
                <h5 class="modal-title" id="imageDetailModalLabel">Chi tiết hình ảnh bài viết</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    <form action="{{ route('imagearticle.store') }}" method="post" enctype="multipart/form-data"
                        class="form-horizontal">
                        @csrf
                        <div class="row form-group align-items-center">
                            <div>
                                <label for="images" class="form-control-label">Thêm ảnh bài viết</label>
                            </div>
                            <div class="col-15 col-md-10">
                                <input type="file" id="images" name="images[]" class="form-control" multiple>
                                @error('images')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col col-md-2">
                                <button type="submit" class="btn btn-success btn-sm">Thêm mới</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row">
                    <div class="">
                        <table style="table-layout: fixed; width: 100%;" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" width="5px">#</th>
                                    <th scope="col" width="30px">Hình ảnh</th>
                                    <th scope="col" width="100px">Link ảnh bài viết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listImageArticle as $index => $listimage)
                                    <tr>
                                        <th scope="row" class="text-center">{{ $index + 1 }}</th>
                                        <td class="text-center">
                                            <img src="{{ asset('storage/' . $listimage->image_url) }}" alt="image"
                                                 width="100px" height="100px">
                                        </td>
                                        <td class="text-center">
                                            <span 
                                                style="cursor: pointer; color: rgb(0, 0, 0); text-decoration: underline;"
                                                onclick="copyToClipboard('{{ asset('storage/' . $listimage->image_url) }}')">
                                                {{ asset('storage/' . $listimage->image_url) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageForm = document.querySelector('form[action="{{ route('imagearticle.store') }}"]');
        
        imageForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn chặn việc gửi form mặc định

            const formData = new FormData(imageForm);

            fetch(imageForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Thêm token CSRF để bảo mật
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateImageTable(data.images); // Gọi hàm để cập nhật bảng
                    imageForm.reset(); // Đặt lại form
                } else {
                    // Xử lý lỗi nếu cần
                    alert('Có lỗi xảy ra, vui lòng thử lại.');
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
            });
        });

        function updateImageTable(images) {
            const tableBody = document.querySelector('table tbody');
            tableBody.innerHTML = ''; // Xóa các hàng hiện tại

            images.forEach((image, index) => {
                const row = `
                    <tr>
                        <th scope="row" class="text-center">${index + 1}</th>
                        <td class="text-center">
                            <img src="{{ asset('storage/') }}/${image.image_url}" alt="image" width="100px" height="100px">
                        </td>
                        <td class="text-center">
                            <span 
                                style="cursor: pointer; color: rgb(0, 0, 0); text-decoration: underline;"
                                onclick="copyToClipboard('{{ asset('storage/') }}/${image.image_url}')">
                                {{ asset('storage/') }}/${image.image_url}
                            </span>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row; // Thêm hàng mới vào bảng
            });
        }
    });
</script>
<!-- Copy link ảnh bài viết -->
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Copy link thành công');
        }, function(err) {
            console.error('Lỗi khi copy link: ', err);
        });
    }
</script>
