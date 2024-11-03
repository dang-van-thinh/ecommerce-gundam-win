<div class="modal fade" id="Reviews-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Write A Review</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form method="POST" action="{{ route('profile.feedback.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="reviews-product d-flex align-items-center">
                                <img src="{{ '/storage/' . $item->productVariant->product->image }}"
                                     style="object-fit: cover;" width="100px" alt="{{ $item->productVariant->product->image }}">
                                <div style="padding:0 20px;" >
                                    <h5>{{ $item->product_name }}</h5>
                                    <p class="mb-1">{{ $item->total_amount }} VND</p>
                                    <ul class="rating p-0 mb-0">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <li>
                                                <input type="radio" id="star{{ $i }}-{{ $item->order_id }}"
                                                       name="rating" value="{{ $i }}" />
                                                <label for="star{{ $i }}-{{ $item->order_id }}">
                                                    <i class="fa-solid fa-star"></i>
                                                </label>
                                            </li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="product_id" value="{{ $item->productVariant->product->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="parent_feedback_id" value="0"> <!-- Đặt 0 cho feedback gốc -->

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Bình luận</label>
                                <textarea class="form-control" name="comment" cols="30" rows="5"
                                          placeholder="Viết bình luận của bạn tại đây..."></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Upload File (optional)</label>
                                <input class="form-control" type="file" name="file_path" />
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-submit" type="submit">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
document.getElementById('Reviews-modal').addEventListener('show.bs.modal', () => {
    document.querySelectorAll('.rating label i').forEach((star) => {
        star.style.color = '#ddd'; // Màu xám mặc định
    });
});

        @if ($errors->any())
        @foreach ($errors->all() as $error)
            Swal.fire({
                title: "Lỗi!",
                text: "{{ $error }}",
                icon: "error"
            });
        @endforeach
    @endif
</script>
@endpush
