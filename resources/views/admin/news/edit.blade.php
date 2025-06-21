@extends('layouts.app')
@section('header_title', 'Edycja artykułu')

@push('styles')
    <style>
        .image-preview {
            max-height: 200px;
            max-width: 100%;
            border-radius: 5px;
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Edycja: {{ Str::limit($post->title, 30) }}</h4>
                    <a class="btn btn-secondary" href="{{ route('admin.news.index') }}">Wróć do listy</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.news.update', $post) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <h5 class="mt-1">Główne informacje</h5>
                        <div class="mb-3"><label class="form-label">Tytuł*</label><input type="text" name="title"
                                class="form-control" value="{{ old('title', $post->title) }}" required></div>
                        <div class="mb-3"><label class="form-label">Link*</label><input type="text" name="slug"
                                class="form-control" value="{{ old('slug', $post->slug) }}" required></div>
                        <div class="mb-3"><label class="form-label">Intro*</label>
                            <textarea name="intro_text" class="form-control" rows="3" required>{{ old('intro_text', $post->intro_text) }}</textarea>
                        </div>
                        <div class="mb-3"><label class="form-label">Subheading*</label>
                            <textarea name="subheading" class="form-control" rows="5" required>{{ old('subheading', $post->subheading) }}</textarea>
                        </div>

                        <hr>
                        <h5>Treść właściwa</h5>
                        <div class="mb-3"><label class="form-label">Akapit 1*</label>
                            <textarea name="content_1" class="form-control" rows="5" required>{{ old('content_1', $post->content_1) }}</textarea>
                        </div>
                        <div class="mb-3"><label class="form-label">Akapit 2</label>
                            <textarea name="content_2" class="form-control" rows="5">{{ old('content_2', $post->content_2) }}</textarea>
                        </div>
                        <div class="mb-3"><label class="form-label">Akapit 3</label>
                            <textarea name="content_3" class="form-control" rows="5">{{ old('content_3', $post->content_3) }}</textarea>
                        </div>

                        <hr>
                        <h5>Zmień zdjęcia (wgraj nowy plik, aby podmienić istniejący)</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Okładka</label>
                                <input type="file" name="cover_image" class="form-control">
                                @if ($post->cover_image_path)
                                    <img src="{{ asset('storage/' . $post->cover_image_path) }}" class="image-preview"
                                        style="display:block;">
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Zdjęcie 1</label>
                                <input type="file" name="image_1" class="form-control">
                                @if ($post->image_1_path)
                                    <img src="{{ asset('storage/' . $post->image_1_path) }}" class="image-preview"
                                        style="display:block;">
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Zdjęcie 2</label>
                                <input type="file" name="image_2" class="form-control">
                                @if ($post->image_2_path)
                                    <img src="{{ asset('storage/' . $post->image_2_path) }}" class="image-preview"
                                        style="display:block;">
                                @endif
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary mt-4">Zapisz zmiany</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
