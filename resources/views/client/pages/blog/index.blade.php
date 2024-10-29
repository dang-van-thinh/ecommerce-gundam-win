@extends('client.layouts.master')
@section('title', $article->title)

@section('content')
@include('client.pages.components.breadcrumb', [
'pageHeader' => 'Bài viết',
'parent' => [
'route' => '',
'name' => 'Trang chủ',
],
])


<section class="section-b-space pt-0">
    <div class="custom-container blog-page container">
        <div class="row gy-4">
            <div class="col-xl-9 col-lg-8 col-12 ratio50_2">
                <div class="blog-main-box blog-details">
                    <div class="blog">
                        <h4>{{ $article->title }}</h4>
                        <hr>
                        <p>{!! $article->content !!}</p>

                        <div class="comments-box">
                            <h5>Comments</h5>
                            <ul class="theme-scrollbar">
                                @foreach($comments as $comment)
                                <li class="col-12">
                                    <div class="comment-items">
                                        <div class="user-img">
                                            <img src="/template/client/assets/images/user/3.jpg" alt="">
                                        </div>
                                        <div class="user-content">
                                            <h6>{{ $comment->user->full_name }}</h6>
                                            <span>{{ $comment->created_at->format('d/m/Y') }}</span>
                                            <p>{{ $comment->comment }}</p>
                                            <a href="#" class="reply-btn" data-comment-id="{{ $comment->id }}">Trả
                                                lời</a>

                                            <!-- Form trả lời bình luận -->
                                            <form action="{{ route('blog.comment.store', $article->id) }}" method="POST"
                                                class="reply-form" id="reply-form-{{ $comment->id }}"
                                                style="display:none;">
                                                @csrf
                                                <input type="hidden" name="parent_comment_id"
                                                    value="{{ $comment->id }}">
                                                <textarea class="form-control" name="comment" rows="3" required
                                                    placeholder="Nhập nội dung bình luận..."></textarea>
                                                <div class="text-end">
                                                    <button class="btn btn-primary btn-sm mt-1"
                                                        type="submit">Gửi</button> 
                                                        <button type="button" class="btn btn-secondary btn-sm mt-1 back-btn" data-comment-id="{{ $comment->id }}">Quay lại</button>
                                                </div>
                                            </form>

                                            <!-- Hiển thị các câu trả lời -->
                                            @if($comment->replies->isNotEmpty())
                                            <ul>
                                                @foreach($comment->replies as $reply)
                                                <li class="col-8 mt-3">
                                                    <div class="comment-items">
                                                        <div class="user-img">
                                                            <img src="/template/client/assets/images/user/3.jpg" alt="">
                                                        </div>
                                                        <div class="user-content">
                                                            <h6>{{ $reply->user->full_name }} trả lời: {{ $comment->user->full_name }}</h6>
                                                            <span>{{ $reply->created_at->format('d/m/Y') }}</span>
                                                            <p>{{ $reply->comment }}</p>
                                                            
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>

                        </div>

                        @if (auth()->check())
                        <form action="{{ route('blog.comment.store', $article->id) }}" method="POST">
                            @csrf
                            <div class="row gy-3 message-box">
                                <div class="col-12">
                                    <label class="form-label">Nội dung bình luận</label>
                                    <textarea class="form-control" name="comment" rows="6"
                                        placeholder="Nhập nội dung của bạn" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn_black sm rounded" type="submit">Đăng bình luận</button>
                                </div>
                            </div>
                        </form>
                        @else
                        <p>Để bình luận, bạn cần <a href="{{ route('auth.login-view') }}">đăng nhập</a>.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 order-lg-first col-12">
                <div class="blog-sidebar sticky">
                    <div class="col-12">
                        <div class="sidebar-box">
                            <div class="sidebar-title">
                                <div class="loader-line"></div>
                                <h5> Thể loại</h5>
                            </div>
                            <ul class="categories">
                                @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('category-articles', $category->id) }}">
                                        <p>{{ $category->name }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span style="color: red">{{ $category->articles_count }}</span>
                                        </p>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="sidebar-box mt-4">
                        <h5>Bài viết mới</h5>
                        <ul class="top-post">
                            @foreach($latestPosts as $post)
                            <li>
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                                <a href="{{ route('blog.show', $post->id) }}">
                                    <h6>{{ $post->title }}</h6>
                                </a>
                                <p>{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chọn tất cả các nút reply
        const replyButtons = document.querySelectorAll('.reply-btn');
        replyButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết
                const commentId = this.getAttribute('data-comment-id'); // Lấy ID của bình luận
                const replyForm = document.getElementById('reply-form-' + commentId); // Lấy form tương ứng
                
                // Ẩn tất cả các form bình luận khác
                document.querySelectorAll('.reply-form').forEach(form => {
                    if (form.id !== replyForm.id) {
                        form.style.display = 'none'; // Ẩn các form khác
                    }
                });
                
                // Toggle hiển thị form bình luận
                replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
            });
        });
        
        // Xử lý nút Quay lại
        const backButtons = document.querySelectorAll('.back-btn');
        backButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const commentId = this.getAttribute('data-comment-id'); // Lấy ID của bình luận
                const replyForm = document.getElementById('reply-form-' + commentId); // Lấy form tương ứng
                replyForm.style.display = 'none'; // Ẩn form khi nhấn "Quay lại"
            });
        });
    });
</script>