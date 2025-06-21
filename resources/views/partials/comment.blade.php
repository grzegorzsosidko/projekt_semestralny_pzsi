<li>
    <div class="comment_item" style="display: flex; gap: 15px;">
        <div class="comment_author_thumbnail">
            <img src="{{ $comment->user->avatar_path ? asset('storage/' . $comment->user->avatar_path) : asset('template/images/default_avatar.webp') }}"
                alt="Avatar użytkownika {{ $comment->user->name }}"
                style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
        </div>
        <div class="comment_author_content">
            <h4 class="comment_author_name">{{ $comment->user->name }}</h4>
            <div class="comment_time" style="font-size: 12px; color: #888;">{{ $comment->created_at->diffForHumans() }}
            </div>
            <p class="mb-0 mt-2">{!! nl2br(e($comment->content)) !!}</p>
            {{-- Przycisk odpowiedzi z poprawnym obrazkiem --}}
            <a class="comment_reply_btn" href="#commentForm" data-comment-id="{{ $comment->id }}"
                data-username="{{ $comment->user->name }}">
                <span class="reply_text">Odpowiedz</span>
                <img class="reply_icon" src="{{ asset('template/images/icons/reply.svg') }}" alt="Reply Icon"
                    style="display:none;">
            </a>
        </div>
    </div>

    {{-- Rekurencja: Jeśli ten komentarz ma odpowiedzi, wyświetl je używając tego samego szablonu --}}
    @if ($comment->replies->isNotEmpty())
        <ul class="comments_list unordered_list_block"
            style="padding-left: 50px; border-left: 2px solid #f0f0f0; margin-left: 25px; margin-top: 15px;">
            @foreach ($comment->replies as $reply)
                @include('partials.comment', ['comment' => $reply])
            @endforeach
        </ul>
    @endif
</li>
