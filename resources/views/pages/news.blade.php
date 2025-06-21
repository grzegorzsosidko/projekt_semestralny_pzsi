@extends('layouts.app')
@section('header_title', 'Aktualności')

@push('styles')
    {{-- Tutaj wklejone są wszystkie Twoje style dla tej podstrony --}}
    <style>
        @media only screen and (min-width: 368px) and (max-width: 1199px) {
            .hovvver {
                padding-left: 0px;
            }
        }

        @media only screen and (min-width: 1350px) and (max-width: 1450px) {
            .blog_post_block.image_left_layout.hovvver {
                display: flex;
                align-items: stretch;
            }

            .blog_post_image {
                flex: 0 0 40%;
            }

            .blog_post_content {
                flex: 1 1 auto;
            }

            .blog_post_image .image_wrap {
                display: flex;
                height: 100%;
            }

            .blog_post_image .image_wrap img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }

            .hovvver {
                padding-left: 0px;
            }

            .category_btns_group a {
                font-size: 12px;
                padding: 5px 10px;
            }
        }

        #main_page {
            container-type: inline-size;
            container-name: mainPage;
        }

        @media only screen and (min-width: 1350px) and (max-width: 1450px) {
            @container mainPage (max-width: 1200px) {
                #blogListContainer {
                    width: 100% !important;
                    display: block;
                }

                .col-lg-4.przyciski_1 {
                    display: none !important;
                }

                .przyciski_1 {
                    display: none;
                }
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
                            <div class="blog_section pb-40">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-8" id="blogListContainer">
                                            @forelse($posts as $post)
                                                <div class="blog_post_block image_left_layout hovvver mb-4">
                                                    <div class="blog_post_image"><a class="image_wrap"
                                                            href="{{ route('news.show', $post->slug) }}"><img
                                                                src="{{ asset('storage/' . $post->cover_image_path) }}"
                                                                alt="{{ $post->title }}"></a></div>
                                                    <div class="blog_post_content">
                                                        <div class="post_meta_wrap">
                                                            <ul class="post_meta unordered_list">
                                                                <li><a href="#!"><i class="far fa-clock"></i>
                                                                        {{ $post->created_at->format('Y-m-d') }}</a></li>
                                                            </ul>
                                                        </div>
                                                        <h3 class="blog_post_title border-effect"><a
                                                                href="{{ route('news.show', $post->slug) }}">{{ $post->title }}</a>
                                                        </h3>
                                                        <p>{{ Str::limit($post->intro_text, 350) }}</p>
                                                        <ul class="post_meta_bottom ul_li">
                                                            <li><img src="{{ $post->user?->avatar_path ? asset('storage/' . $post->user->avatar_path) : asset('template/images/default_avatar.webp') }}"
                                                                    class="rounded-circle" width="24" height="24"
                                                                    alt="Avatar"> {{ $post->user->name ?? 'Autor' }}</li>
                                                            <li><i class="far fa-comment"></i> {{ $post->comments_count }}
                                                            </li>
                                                            <li><i class="far fa-eye"></i> {{ $post->views_count }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            @empty
                                                <p>Obecnie nie ma żadnych aktualności do wyświetlenia.</p>
                                            @endforelse
                                            <div class="mt-4">{{ $posts->links() }}</div>
                                        </div>
                                        <div class="col-lg-4 przyciski_1 only_pc">
                                            <aside class="sidebar ps-xl-5">
                                                <div class="post_list_block">
                                                    <h3 class="sidebar_widget_title">Ostatnie artykuły</h3>
                                                    <ul class="unordered_list_block">
                                                        @foreach ($latestPosts as $latest)
                                                            <li>
                                                                <div class="post_image"><a
                                                                        href="{{ route('news.show', $latest->slug) }}"><img
                                                                            src="{{ asset('storage/' . $latest->cover_image_path) }}"
                                                                            alt="Miniaturka"></a></div>
                                                                <div class="post_holder">
                                                                    <h3 class="post_title border-effect-2"><a
                                                                            href="{{ route('news.show', $latest->slug) }}">{{ Str::limit($latest->title, 40) }}</a>
                                                                    </h3>
                                                                    <a class="post_date"
                                                                        href="{{ route('news.show', $latest->slug) }}"><i
                                                                            class="far fa-clock"></i>
                                                                        {{ $latest->created_at->format('Y-m-d') }}</a>
                                                                </div>
                                                            </li>
                                                        @endforeach
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