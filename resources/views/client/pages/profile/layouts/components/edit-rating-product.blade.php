<div class="modal fade" id="EditReview-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Chỉnh sửa đánh giá</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form method="POST" action="{{ route('profile.feedback.update', $userFeedback->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="reviews-product d-flex align-items-center">
                                <img src="{{ '/storage/' . $item->productVariant->product->image }}" style="object-fit: cover;" width="100px" alt="{{ $item->productVariant->product->image }}">
                                <div style="padding:0 20px;">
                                    <h5>{{ $item->product_name }}</h5>
                                    <p class="mb-1">{{ $item->total_amount }} VND</p>
                                    <ul class="rating p-0 mb-0">
                                        @php
                                            $stars = range(1, 5); // Tạo mảng sao từ 1 đến 5
                                            $currentRating = old('rating', $userFeedback->rating); // Lưu rating hiện tại hoặc giá trị cũ nếu có
                                        @endphp
                                        @foreach ($stars as $i)
    <li>
        <input type="radio" id="star{{ $i }}-{{ $userFeedback->id }}" name="rating" value="{{ $i }}" {{ $currentRating == $i ? 'checked' : '' }} />
        <label for="star{{ $i }}-{{ $userFeedback->id }}">
            <i class="fa-solid fa-star"></i>
        </label>
    </li>
@endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="product_id" value="{{ $item->productVariant->product->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="parent_feedback_id" value="{{ $userFeedback->parent_feedback_id }}">

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Bình luận</label>
                                <textarea class="form-control" name="comment" cols="30" rows="5" placeholder="Viết bình luận của bạn tại đây...">{{ $userFeedback->comment }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Ảnh hiện tại:</label>
                                @if($userFeedback->file_path)
                                    <div>
                                        <img src="{{ '/storage/' . $userFeedback->file_path }}" alt="Ảnh hiện tại" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                    </div>
                                @endif
                                <label class="form-label">Upload File (tùy chọn)</label>
                                <input class="form-control" type="file" name="file_path" />
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-submit" type="submit">
                                Lưu thay đổi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.querySelectorAll('input[name="rating"]').forEach((input) => {
    input.addEventListener('change', (event) => {
        const rating = parseInt(event.target.value, 10);
        const stars = event.target.closest('.rating').querySelectorAll('label i');

        // Đổi màu tất cả các ngôi sao dựa trên số sao đã chọn
        stars.forEach((star, index) => {
            star.style.color = index < rating ? '#f39c12' : '#ddd'; // Màu vàng (#f39c12) cho sao đã chọn, xám (#ddd) cho sao chưa chọn
        });
    });
});

// Khi modal EditReview-modal được mở, thiết lập màu sao theo giá trị rating đã lưu
document.getElementById('EditReview-modal').addEventListener('show.bs.modal', () => {
    document.querySelectorAll('.rating').forEach((ratingElement) => {
        const selectedInput = ratingElement.querySelector('input[name="rating"]:checked');
        if (selectedInput) {
            const rating = parseInt(selectedInput.value, 10);
            const stars = ratingElement.querySelectorAll('label i');

            // Đổi màu các sao dựa trên giá trị rating đã lưu
            stars.forEach((star, index) => {
                star.style.color = index < rating ? '#f39c12' : '#ddd'; // Màu vàng (#f39c12) cho sao đã chọn, xám (#ddd) cho sao chưa chọn
            });
        }
    });
});

</script>
@endpush
