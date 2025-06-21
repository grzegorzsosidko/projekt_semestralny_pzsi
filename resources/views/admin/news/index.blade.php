@extends('layouts.app')
@section('header_title', 'Zarządzaj aktualnościami')

@push('styles')
    <style>
        .list-group-item {
            cursor: pointer;
            transition: background-color .2s ease-in-out
        }

        .list-group-item.active {
            background-color: #e4f5fc;
            border-color: #bde5f8;
            font-weight: 700
        }

        .status-icon {
            font-size: 10px
        }

        .crancy-pcats__list a {
            font-size: 12px;
            padding: 10px 20px;
            border-radius: 4px !important
        }
    </style>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('status') }}<button
                        type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Lista artykułów</h4>
                    <div class="crancy-pcats__list list-group">
                        <a class="list-group-item btn btn-primary" href="{{ route('admin.news.create') }}">Dodaj blog</a>
                        <a class="list-group-item btn btn-primary disabled" href="#" id="editBlogBtn">Edytuj blog</a>
                        <a class="list-group-item btn btn-primary disabled" href="#" id="toggleBlogBtn">Ukryj blog</a>
                        <a class="list-group-item btn btn-danger disabled" href="#" id="deleteBlogBtn">Usuń blog</a>
                        <a class="list-group-item btn btn-primary disabled" href="#" id="previewBlogBtn"
                            target="_blank">Podgląd bloga</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="list-group" id="blogList">
                        @forelse($posts as $post)
                            <a href="javascript:void(0)"
                                class="list-group-item list-group-item-action flex-column align-items-start"
                                data-id="{{ $post->id }}" data-slug="{{ $post->slug }}"
                                data-is-hidden="{{ $post->is_hidden ? '1' : '0' }}">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><i
                                            class="fa fa-circle status-icon me-2 {{ $post->is_hidden ? 'text-danger' : 'text-success' }}"></i>{{ $post->title }}
                                    </h5>
                                    <small class="text-muted">{{ $post->created_at->format('Y-m-d') }}</small>
                                </div>
                                <p class="mb-1">{{ Str::limit($post->intro_text, 100) }}</p>
                                <small class="text-muted">Autor: {{ $post->user->name ?? 'Brak' }} | Wyświetleń:
                                    {{ $post->views_count }} | Komentarzy: {{ $post->comments_count }}</small>
                            </a>
                        @empty
                            <p class="text-center p-3">Brak artykułów. Dodaj pierwszy!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="actionForm" method="POST" style="display: none;">@csrf<input type="hidden" name="_method"
            id="formMethodInput"></form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedPostId = null,
                selectedPostSlug = null,
                selectedIsHidden = false;
            const editBtn = document.getElementById('editBlogBtn');
            const toggleBtn = document.getElementById('toggleBlogBtn');
            const deleteBtn = document.getElementById('deleteBlogBtn');
            const previewBtn = document.getElementById('previewBlogBtn');
            const blogList = document.getElementById('blogList');
            const actionForm = document.getElementById('actionForm');
            const formMethodInput = document.getElementById('formMethodInput');

            function updateButtonStates() {
                if (selectedPostId) {
                    editBtn.href = `{{ url('admin/news') }}/${selectedPostId}/edit`;
                    editBtn.classList.remove('disabled');
                    toggleBtn.classList.remove('disabled');
                    deleteBtn.classList.remove('disabled');
                    toggleBtn.textContent = selectedIsHidden ? 'Opublikuj blog' : 'Ukryj blog';
                    if (selectedIsHidden) {
                        previewBtn.classList.add('disabled');
                        previewBtn.href = '#';
                    } else {
                        previewBtn.classList.remove('disabled');
                        previewBtn.href = `{{ url('aktualnosci') }}/${selectedPostSlug}`;
                    }
                } else {
                    [editBtn, toggleBtn, deleteBtn, previewBtn].forEach(btn => {
                        btn.classList.add('disabled');
                        btn.href = '#';
                    });
                    toggleBtn.textContent = 'Ukryj/Odkryj';
                }
            }

            blogList.addEventListener('click', e => {
                const item = e.target.closest('.list-group-item');
                if (!item) return;
                if (item.classList.contains('active')) {
                    item.classList.remove('active');
                    selectedPostId = null;
                } else {
                    document.querySelectorAll('#blogList .list-group-item').forEach(el => el.classList
                        .remove('active'));
                    item.classList.add('active');
                    selectedPostId = item.dataset.id;
                    selectedPostSlug = item.dataset.slug;
                    selectedIsHidden = item.dataset.isHidden === '1';
                }
                updateButtonStates();
            });

            toggleBtn.addEventListener('click', e => {
                e.preventDefault();
                if (e.target.classList.contains('disabled')) return;
                actionForm.action = `{{ url('admin/news') }}/${selectedPostId}/toggle-status`;
                formMethodInput.value = 'POST'; // Laravel >9 obsłuży to jako PATCH przez middleware
                actionForm.submit();
            });

            deleteBtn.addEventListener('click', e => {
                e.preventDefault();
                if (e.target.classList.contains('disabled')) return;
                if (confirm('Czy na pewno chcesz usunąć ten artykuł? Tej operacji nie można cofnąć.')) {
                    actionForm.action = `{{ url('admin/news') }}/${selectedPostId}`;
                    formMethodInput.value = 'DELETE';
                    actionForm.submit();
                }
            });
        });
    </script>
@endpush
