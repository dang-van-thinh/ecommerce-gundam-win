<li class="col-12">
    <div class="comment-items d-flex flex-column" style="gap: 0px;">
        <div class="comment-author d-flex">
            <div class="userImg" style="border-radius: 50%;">
                <img src="/template/client/assets/images/user/3.jpg" alt="">
            </div>
            <div class="d-flex flex-column">
                <div class="user-name">
                    <h6>
                        {{-- Kiểm tra xem đây có phải bình luận con không --}}
                        @if ($comment->parent_comment_id)
                        {{ $comment->user->full_name }} trả lời: <strong style="color: rgb(110, 110, 238)">{{
                            $comment->parent->user->full_name }}</strong>
                        @else
                        {{ $comment->user->full_name }}
                        @endif
                    </h6>
                </div>
                <div class="comment-date">
                    {{ $comment->comment }}
                    <a href="#" class="reply-btn" data-comment-id="{{ $comment->id }}">Trả lời</a>
                </div>
                <span>{{ $comment->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
        <div class="comment-text">
            <!-- Form trả lời bình luận -->
            <form action="{{ route('blog.comment.store', $article->id) }}" method="POST" class="reply-form"
                id="reply-form-{{ $comment->id }}" style="display:none;">
                @csrf
                <input type="hidden" name="parent_comment_id" value="{{ $comment->id }}">
                <textarea class="form-control" name="comment" rows="2" cols="50" required
                    placeholder="Nhập nội dung bình luận..."></textarea>
                <div class="text-end">
                    <button class="btn btn-primary btn-sm mt-1" type="submit">Gửi</button>
                    <button type="button" class="btn btn-secondary btn-sm back-btn mt-1"
                        data-comment-id="{{ $comment->id }}">Quay lại</button>
                </div>
            </form>

            <!-- Hiển thị các câu trả lời -->
            @if ($comment->replies->isNotEmpty())
            <ul >
                @foreach ($comment->replies as $reply)
                    <li>
                        @include('client.pages.blog.comment_render', ['comment' => $reply])
                    </li>
                @endforeach
            </ul>
        @endif
        
        </div>

    </div>
   
</li>