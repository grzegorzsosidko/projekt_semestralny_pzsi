@extends('layouts.app')
@section('header_title', 'Edytuj galerię')

@push('styles')
    <style>
        #preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }

        .img-preview-wrapper {
            position: relative;
        }

        .img-preview {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 5px;
        }

        .remove-img-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 20px;
            height: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
        }

        .progress {
            display: none;
        }
    </style>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edycja galerii: {{ $gallery->title }}</h4>
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
                    <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3"><label class="form-label">Tytuł galerii*</label><input type="text"
                                name="title" class="form-control" value="{{ old('title', $gallery->title) }}" required>
                        </div>
                        <div class="mb-3"><label class="form-label">Opis galerii*</label>
                            <textarea name="description" class="form-control" style="min-height: 240px !important" required>{{ old('description', $gallery->description) }}</textarea>
                        </div>

                        <hr>
                        <h5>Istniejące zdjęcia</h5>

                        @if ($gallery->images->isNotEmpty())
                            <p>Zaznacz, aby usunąć:</p>
                            <div id="preview-grid">
                                @foreach ($gallery->images as $image)
                                    <div class="img-preview-wrapper">
                                        <img src="{{ asset('storage/' . $image->thumbnail_path) }}" class="img-preview">
                                        <div
                                            class="form-check position-absolute top-0 start-0 m-1 bg-white rounded-circle p-1">
                                            <input class="form-check-input" type="checkbox" name="delete_images[]"
                                                value="{{ $image->id }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>Brak zdjęć w tej galerii.</p>
                        @endif

                        <div class="mb-3 mt-4"><label class="form-label">Dodaj nowe zdjęcia</label><input type="file"
                                name="images[]" class="form-control" multiple></div>
                        <button type="submit" class="btn btn-primary mt-4">Zapisz zmiany</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
