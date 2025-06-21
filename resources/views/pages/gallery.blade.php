@extends('layouts.app')
@section('header_title', 'Galeria Zdjęć')

@push('styles')
<style>
    .gallery-item { margin-bottom: 2.5rem; }
    .gallery-title { border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 10px; }
    .gallery-thumbnail { height: 200px; width: 100%; object-fit: cover; border-radius: 10px; cursor: pointer; transition: transform 0.2s; }
    .gallery-thumbnail:hover { transform: scale(1.05); }
</style>
@endpush

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Galeria zdjęć</h4></div>
            <div class="card-body pb-1">
                @forelse($galleries as $gallery)
                    <div class="gallery-item">
                        <div class="row">
                            <div class="col-xl-9">
                                <h5 class="card-title card-intro-title gallery-title">{{ $gallery->title }}</h5>
                                <p>{{ $gallery->description }}</p>
                            </div>
                            <div class="col-xl-3 text-end">
                                <small>
                                    Dodano: {{ $gallery->created_at->format('Y-m-d') }}<br>
                                    @if(Auth::user()->role == 'administrator')
                                        <b>Przez: {{ $gallery->user->name ?? 'Brak danych' }}</b>
                                    @endif
                                </small>
                            </div>
                        </div>
                        <div class="row lightgallery-container" id="lightgallery-{{ $gallery->id }}">
                            @foreach($gallery->images as $image)
                                <a href="{{ asset('storage/' . $image->path) }}" class="col-lg-3 col-md-6 mb-4">
                                    <img class="gallery-thumbnail" loading="lazy" src="{{ asset('storage/' . $image->thumbnail_path) }}" alt="Zdjęcie z galerii {{ $gallery->title }}">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-center p-4">Obecnie nie ma żadnych galerii do wyświetlenia.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.lightgallery-container').forEach(el => {
        lightGallery(el, {
            plugins: [lgZoom, lgThumbnail],
            speed: 500,
            download: false,
        });
    });
});
</script>
@endpush
