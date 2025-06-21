@extends('layouts.app')

@section('header_title', 'Dokumenty Firmowe')

@push('styles')
<style>
    .accordion-with-icon .accordion-button .accordion-header-icon::before { content: "\e6a4"; }
    .accordion-with-icon .accordion-button.multiple-files .accordion-header-icon::before { content: "\e6a3"; }
    .document-link a { display: inline-block; max-width: 240px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; vertical-align: middle; }
</style>
@endpush

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-block">
                        <h4 class="card-title" style="text-transform: none;">Ważne dokumenty</h4>
                        <div class="mt-3 mb-2">
                            <input type="text" id="searchInput" placeholder="Wyszukaj dokument po tytule lub opisie..." class="form-control">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="accordion accordion-with-icon" id="documentsAccordion">

                            @forelse ($documents as $document)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $document->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $document->id }}">
                                            <span class="accordion-header-icon"></span>
                                            <span class="accordion-header-text">{{ $document->title }}</span>
                                            <ul class="category_btns_group unordered_list only_pc">
                                                <li><a>{{ $document->category->name }}</a></li>
                                            </ul>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $document->id }}" class="accordion-collapse collapse" data-bs-parent="#documentsAccordion">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <b>Opis dokumentu</b>
                                                <span class="add-date only_pc">{{ $document->created_at->format('Y-m-d') }}</span>
                                            </div>
                                            <p class="description-document">{{ $document->description }}</p>
                                            <hr>
                                            <div class="basic-list-group">
                                                <b>Zawartość do pobrania</b>
                                                @if($document->files->isNotEmpty())
                                                    <ul class="list-group pt-10">
                                                        @foreach($document->files as $file)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <span class="document-link">
                                                                <a href="{{ Storage::url($file->path) }}" target="_blank">{{ $file->original_name }}</a>
                                                            </span>
                                                            <a href="{{ Storage::url($file->path) }}" target="_blank" class="btn btn-outline-primary btn-xs only_pc" download>Pobierz</a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="mt-2">Brak załączników.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center">Brak dostępnych dokumentów.</p>
                            @endforelse

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
    const searchInput = document.getElementById('searchInput');
    const accordion = document.getElementById('documentsAccordion');
    const items = accordion.getElementsByClassName('accordion-item');

    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();

        for (let i = 0; i < items.length; i++) {
            let item = items[i];
            // Szukamy w tytule (accordion-header-text) i opisie (description-document)
            let title = item.querySelector('.accordion-header-text').textContent.toLowerCase();
            let description = item.querySelector('.description-document').textContent.toLowerCase();

            if (title.indexOf(filter) > -1 || description.indexOf(filter) > -1) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        }
    });
});
</script>
@endpush
