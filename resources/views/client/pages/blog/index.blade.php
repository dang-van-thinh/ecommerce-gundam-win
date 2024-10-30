@extends('client.layouts.master')
@section('title', $article->title)

@push('css')
    <style>
        .post-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .top-post-title h6 {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
            margin: 0;
            font-size: 1em;
            font-weight: bold;
        }

        .post-date p {
            margin: 5px 0 0;
            color: #666;
            font-size: 0.9em;
        }

        .userImg {
            width: 40px;
            height: 40px;
            overflow: hidden;
            margin-right: 10px;
        }

        .userImg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-name h6 {
            margin-bottom: 0px;
            font-weight: 500px;
            width: 600px;
        }

        .comment-text {
            margin-left: 15px;
            margin-top: 3px;
            font-size: 17px;
        }

        .reply-btn {
            margin-left: 10px;
        }

        .reply-btn:hover {
            color: rgba(var(--theme-default), 1);
        }

        .reply-item {
            margin-left: 25px
        }
    </style>
@endpush
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
                                    @foreach ($comments as $comment)
                                        <li class="col-12">
                                            <div class="comment-items d-flex flex-column" style="gap: 0px; ">
                                                <div class="comment-author d-flex">
                                                    <div class="userImg" style="border-radius: 50%;">
                                                        <img src="/template/client/assets/images/user/3.jpg" alt="">
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <div class="user-name">
                                                            <h6>{{ $comment->user->full_name }}</h6>
                                                        </div>
                                                        <div class="comment-date">
                                                            <span>{{ $comment->created_at->format('d/m/Y') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="comment-text">
                                                    {{ $comment->comment }}
                                                    <a href="#" class="reply-btn"
                                                        data-comment-id="{{ $comment->id }}">Trả
                                                        lời</a>

                                                    <!-- Form trả lời bình luận -->
                                                    <form action="{{ route('blog.comment.store', $article->id) }}"
                                                        method="POST" class="reply-form"
                                                        id="reply-form-{{ $comment->id }}" style="display:none;">
                                                        @csrf
                                                        <input type="hidden" name="parent_comment_id"
                                                            value="{{ $comment->id }}">
                                                        <textarea class="form-control" name="comment" rows="3" required placeholder="Nhập nội dung bình luận..."></textarea>
                                                        <div class="text-end">
                                                            <button class="btn btn-primary btn-sm mt-1"
                                                                type="submit">Gửi</button>
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm back-btn mt-1"
                                                                data-comment-id="{{ $comment->id }}">Quay lại</button>
                                                        </div>
                                                    </form>

                                                    <!-- Hiển thị các câu trả lời -->
                                                    @if ($comment->replies->isNotEmpty())
                                                        <ul>
                                                            @foreach ($comment->replies as $reply)
                                                                <li class="reply-item mt-3">
                                                                    <div class="comment-author d-flex">
                                                                        <div class="userImg" style="border-radius: 50%;">
                                                                            <img src="/template/client/assets/images/user/3.jpg"
                                                                                alt="">
                                                                        </div>
                                                                        <div class="d-flex flex-column">
                                                                            <div class="user-name">
                                                                                <h6>
                                                                                    {{ $reply->user->full_name }} trả lời:
                                                                                    {{ $comment->user->full_name }}
                                                                                </h6>
                                                                            </div>
                                                                            <div class="comment-date">
                                                                                <span>
                                                                                    {{ $reply->created_at->format('d/m/Y') }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="comment-text">
                                                                        {{ $reply->comment }}
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
                                            <textarea class="form-control" name="comment" rows="6" placeholder="Nhập nội dung của bạn" required></textarea>
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
                                    @foreach ($categories as $category)
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
                                @foreach ($latestPosts as $post)
                                    <li class="post-item">
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                                        <div class="post-content d-flex flex-column">
                                            <a href="{{ route('blog.show', $post->id) }}">
                                                <div class="top-post-title">
                                                    <h6>{{ $post->title }}</h6>
                                                </div>
                                            </a>
                                            <div class="post-date">
                                                <p>{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
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
                const replyForm = document.getElementById('reply-form-' +
                    commentId); // Lấy form tương ứng

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
                const replyForm = document.getElementById('reply-form-' +
                    commentId); // Lấy form tương ứng
                replyForm.style.display = 'none'; // Ẩn form khi nhấn "Quay lại"
            });
        });
    });
</script>
