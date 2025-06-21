@extends('layouts.app')
@section('header_title', $post->title)

@push('styles')
    {{-- Twoje style z Zadania 4 --}}
    <style>
        #mySidebar {
            padding-left: 50px;
        }

        .comment_reply_btn .reply_text {
            display: inline;
        }

        .comment_reply_btn .reply_icon {
            display: none;
            width: 18px;
            height: auto;
            vertical-align: middle;
        }

        @media (max-width:992px) {
            .comment_reply_btn .reply_text {
                display: none;
            }

            .comment_reply_btn .reply_icon {
                display: inline;
            }
        }

        @media only screen and (min-width:368px) and (max-width:1199px) {
            #mySidebar {
                padding-left: 15px;
            }

            .comment_item .comment_author_thumbnail {
                width: 40px;
                height: 40px;
            }

            .comment_item {
                gap: 15px;
            }

            .comments_list {
                gap: 20px;
            }

            .comments_list>li .comments_list {
                padding: 10px 0 25px 20px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="blog_details_section section_space">
                                <div class="details_item_image"><img class="blog_cover_image"
                                        src="{{ asset('storage/' . $post->cover_image_path) }}" alt="{{ $post->title }}">
                                </div>
                                <div class="container" style="max-width:1250px;">
                                    <div class="post_meta_wrap mb-4">
                                        <ul class="post_meta unordered_list">
                                            <li><a href="javascript:void(0)"><i class="far fa-clock"></i>
                                                    {{ $post->created_at->format('d-m-Y') }}</a></li>
                                        </ul>
                                    </div>
                                    <h2 class="details_item_title">{{ $post->title }}</h2>
                                    <p>{{ $post->intro_text }}</p>
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <ul class="post_meta_bottom ul_li">
                                                <li><img src="{{ $post->user->avatar_path ? asset('storage/' . $post->user->avatar_path) : asset('template/images/default_avatar.webp') }}"
                                                        class="rounded-circle" width="24" height="24" alt="Avatar">
                                                    {{ $post->user->name }}</li>
                                                <li><i class="far fa-comment"></i>
                                                    {{ $post->comments->count() + $post->comments->sum(fn($c) => $c->replies->count()) }}
                                                </li>
                                                <li><i class="far fa-eye"></i> {{ $post->views_count }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <hr class="mb-0">
                                    <div class="row mt-40">
                                        <div class="col-lg-8 mt-30" id="articleContent">
                                            <div class="blog_details_audio mb-4"><button class="audio_play_btn"
                                                    type="button" id="audioPlayBtn"><i
                                                        class="fas fa-play"></i><span>Odsłuchaj treść
                                                        artykułu</span></button></div>
                                            <h3 class="details_item_info_title mb-3">{!! nl2br(e($post->subheading)) !!}</h3>
                                            <div class="content_section">
                                                <p>{!! nl2br(e($post->content_1)) !!}</p>
                                            </div>
                                            @if ($post->image_1_path)
                                                <div class="my-4"><img src="{{ asset('storage/' . $post->image_1_path) }}"
                                                        alt="Zdjęcie z artykułu" class="img-fluid rounded"></div>
                                            @endif
                                            @if ($post->content_2)
                                                <div class="content_section">
                                                    <p>{!! nl2br(e($post->content_2)) !!}</p>
                                                </div>
                                            @endif
                                            @if ($post->image_2_path)
                                                <div class="my-4"><img
                                                        src="{{ asset('storage/' . $post->image_2_path) }}"
                                                        alt="Zdjęcie z artykułu" class="img-fluid rounded"></div>
                                            @endif
                                            @if ($post->content_3)
                                                <div class="content_section">
                                                    <p>{!! nl2br(e($post->content_3)) !!}</p>
                                                </div>
                                            @endif
                                            <hr>
                                            <div class="comment_area mt-30">
                                                <h3 class="details_item_info_title mb-5">Komentarze</h3>
                                                @if (session('status'))
                                                    <div class="alert alert-success">{{ session('status') }}</div>
                                                @endif
                                                <ul class="comments_list unordered_list_block">
                                                    @forelse($post->comments as $comment)
                                                        @include('partials.comment', [
                                                            'comment' => $comment,
                                                        ])
                                                    @empty
                                                        <li>
                                                            <p>Brak komentarzy. Bądź pierwszy!</p>
                                                        </li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                            <div class="col-lg-12 mt-30">
                                                <hr class="m-0">
                                                <div class="mb-50 mt-30">
                                                    <h3 class="details_item_info_title mb-1">Zostaw komentarz</h3>
                                                    <form id="commentForm" action="{{ route('comments.store', $post) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="parent_id" id="parent_comment_id"
                                                            value="">
                                                        <div class="form-group">
                                                            <textarea id="commentContent" name="content" class="form-control" style="min-height: 120px !important;" required
                                                                placeholder="Napisz swój komentarz..."></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary mt-3">Wyślij
                                                            komentarz</button>
                                                        <button type="button" class="btn btn-secondary mt-3 d-none"
                                                            id="cancelReplyBtn">Anuluj odpowiedź</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <aside class="sidebar ps-xl-5">
                                                <div class="post_list_block">
                                                    <h3 class="sidebar_widget_title">Ostatnie artykuły</h3>
                                                    <ul class="unordered_list_block">
                                                        @forelse($latestPosts as $latest)
                                                            <li>
                                                                <div class="post_image"><a
                                                                        href="{{ route('news.show', $latest->slug) }}"><img
                                                                            src="{{ asset('storage/' . $latest->cover_image_path) }}"
                                                                            alt="Miniaturka"></a></div>
                                                                <div class="post_holder">
                                                                    <h3 class="post_title border-effect-2"><a
                                                                            href="{{ route('news.show', $latest->slug) }}">{{ Str::limit($latest->title, 40) }}</a>
                                                                    </h3><a class="post_date"
                                                                        href="{{ route('news.show', $latest->slug) }}"><i
                                                                            class="far fa-clock"></i>
                                                                        {{ $latest->created_at->format('Y-m-d') }}</a>
                                                                </div>
                                                            </li>
                                                        @empty
                                                            <li>
                                                                <p>Brak innych artykułów.</p>
                                                            </li>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </aside>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Logika dla Lektora ---
            const audioBtn = document.getElementById('audioPlayBtn');
            if (audioBtn) {
                let isPlaying = false,
                    isPaused = false;
                const textToSpeak = [@json($post->title), @json($post->intro_text),
                    @json($post->subheading), @json($post->content_1), @json($post->content_2),
                    @json($post->content_3)
                ].filter(Boolean).join('. ');
                const utterance = new SpeechSynthesisUtterance(textToSpeak);
                utterance.lang = 'pl-PL';
                utterance.onend = () => {
                    isPlaying = false;
                    isPaused = false;
                    updateButtonUI();
                };

                function updateButtonUI() {
                    const icon = audioBtn.querySelector('i');
                    const textSpan = audioBtn.querySelector('span');
                    icon.className = isPlaying && !isPaused ? 'fas fa-pause' : 'fas fa-play';
                    textSpan.textContent = isPlaying && !isPaused ? "Pauzuj" : (isPaused ? "Wznów" :
                        "Odsłuchaj treść");
                }
                audioBtn.addEventListener('click', () => {
                    if (!speechSynthesis) return;
                    if (!isPlaying) {
                        speechSynthesis.speak(utterance);
                        isPlaying = true;
                    } else {
                        isPaused ? speechSynthesis.resume() : speechSynthesis.pause();
                        isPaused = !isPaused;
                    }
                    updateButtonUI();
                });
                window.addEventListener('beforeunload', () => speechSynthesis.cancel());
            }

            // --- Logika dla Odpowiadania na Komentarze ---
            const commentForm = document.getElementById('commentForm');
            const parentIdInput = document.getElementById('parent_comment_id');
            const commentContent = document.getElementById('commentContent');
            const cancelReplyBtn = document.getElementById('cancelReplyBtn');
            document.querySelectorAll('.comment_reply_btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    parentIdInput.value = this.dataset.commentId;
                    commentContent.placeholder =
                        `Odpowiadasz użytkownikowi @${this.dataset.username}...`;
                    commentContent.focus();
                    cancelReplyBtn.classList.remove('d-none');
                    commentForm.scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
            cancelReplyBtn.addEventListener('click', () => {
                parentIdInput.value = '';
                commentContent.placeholder = 'Napisz swój komentarz...';
                cancelReplyBtn.classList.add('d-none');
            });
        });
    </script>
@endpush
