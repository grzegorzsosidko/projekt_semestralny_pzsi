@extends('layouts.app')
@section('header_title', 'Dodaj nowy artykuł')

@push('styles')
    <style>
        .image-preview-container {
            text-align: center;
            border: 2px dashed #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .image-preview {
            max-height: 200px;
            max-width: 100%;
            margin-top: 10px;
            display: none;
        }
    </style>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Dodaj nowy artykuł</h4>
                    <a class="btn btn-secondary" href="{{ route('admin.news.index') }}">Wróć do listy</a>
                </div>
                <div class="card-body">
                    <form id="newsForm" action="{{ route('admin.news.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- Główne informacje --}}
                        <div class="mb-3"><label for="titleField" class="form-label">Tytuł (max 65 znaków)*</label><input
                                type="text" name="title" class="form-control" id="titleField" maxlength="65"
                                placeholder="Wpisz tytuł..." required /></div>
                        <div class="mb-3"><label class="form-label">Link (generowany)</label><input type="text"
                                name="slug" class="form-control form-control-sm" id="linkPreview" readonly /></div>
                        <div class="mb-3"><label class="form-label">Tekst otwierający (intro)*</label>
                            <textarea name="intro_text" class="form-control" style="min-height: 150px !important" required></textarea>
                        </div>
                        <div class="mb-3"><label class="form-label">Wstęp do tekstu (subheading)*</label>
                            <textarea name="subheading" class="form-control" style="min-height: 250px !important" required></textarea>
                        </div>

                        <hr>
                        <h5>Treść właściwa i zdjęcia</h5>
                        <div class="mb-3"><label class="form-label">Okładka artykułu*</label><input type="file"
                                name="cover_image" class="form-control" id="cover_image" required accept="image/*"><img
                                id="cover_image_preview" class="image-preview" alt="Podgląd okładki"></div>
                        <div class="mb-3"><label class="form-label">Akapit 1*</label>
                            <textarea name="content_1" class="form-control" style="min-height: 350px !important" required></textarea>
                        </div>
                        <div class="mb-3"><label class="form-label">Zdjęcie w treści nr 1 (opcjonalnie)</label><input
                                type="file" name="image_1" class="form-control" id="image_1" accept="image/*"><img
                                id="image_1_preview" class="image-preview"></div>
                        <div class="mb-3"><label class="form-label">Akapit 2</label>
                            <textarea name="content_2" class="form-control" style="min-height: 350px !important"></textarea>
                        </div>
                        <div class="mb-3"><label class="form-label">Zdjęcie w treści nr 2 (opcjonalnie)</label><input
                                type="file" name="image_2" class="form-control" id="image_2" accept="image/*"><img
                                id="image_2_preview" class="image-preview"></div>
                        <div class="mb-3"><label class="form-label">Akapit 3</label>
                            <textarea name="content_3" class="form-control" style="min-height: 350px !important"></textarea>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary" id="saveNewsBtn">Opublikuj artykuł</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const titleField = document.getElementById('titleField');
            const linkPreview = document.getElementById('linkPreview');
            const newsForm = document.getElementById('newsForm');

            function createSlug(text) {
                const a = 'àáâäæãåāăąçćčđďèéêëēėęěğǵḧîïíīįìłḿñńǹňôöòóœøōõőṕŕřßśšşșťțûüùúūǘůűųẃẍÿýžźż·/_,:;'
                const b = 'aaaaaaaaaacccddeeeeeeeegghiiiiiilmnnnnoooooooooprrsssssttuuuuuuuuuwxyyzzz------'
                const p = new RegExp(a.split('').join('|'), 'g')
                return text.toString().toLowerCase().replace(/\s+/g, '-').replace(p, c => b.charAt(a.indexOf(c)))
                    .replace(/&/g, '-and-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-').replace(/^-+/, '')
                    .replace(/-+$/, '');
            }
            titleField.addEventListener('keyup', () => {
                linkPreview.value = createSlug(titleField.value);
            });

            function setupImagePreview(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                input.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = e => {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(this.files[0]);
                    } else {
                        preview.style.display = 'none';
                    }
                });
            }
            setupImagePreview('cover_image', 'cover_image_preview');
            setupImagePreview('image_1', 'image_1_preview');
            setupImagePreview('image_2', 'image_2_preview');

            newsForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const submitBtn = document.getElementById('saveNewsBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    `<span class="spinner-border spinner-border-sm"></span> Przetwarzanie...`;
                const formData = new FormData(this);
                const xhr = new XMLHttpRequest();
                xhr.open('POST', this.action, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')
                    .getAttribute('content'));
                xhr.setRequestHeader('Accept', 'application/json');
                Swal.fire({
                    title: 'Przesyłanie...',
                    html: '<div class="progress mt-3"><div class="progress-bar progress-bar-striped progress-bar-animated" id="uploadProgressBar" style="width: 0%">0%</div></div>',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => Swal.showLoading()
                });
                xhr.upload.addEventListener('progress', e => {
                    if (e.lengthComputable) {
                        const percentComplete = Math.round((e.loaded / e.total) * 100);
                        const progressBar = Swal.getHtmlContainer()?.querySelector(
                            '#uploadProgressBar');
                        if (progressBar) {
                            progressBar.style.width = percentComplete + '%';
                            progressBar.textContent = percentComplete + '%';
                        }
                    }
                });
                xhr.onload = function() {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Opublikuj artykuł';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (xhr.status >= 200 && xhr.status < 300 && response.success) {
                            Swal.fire({
                                title: 'Sukces!',
                                text: 'Artykuł został pomyślnie dodany.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => window.location.href = response.redirect_url);
                        } else {
                            let errorMsg = 'Wystąpiły błędy:\n\n' + (response.message || '');
                            if (response.errors) {
                                for (const field in response.errors) {
                                    errorMsg += `• ${response.errors[field].join(', ')}\n`;
                                }
                            }
                            Swal.fire('Błąd!', errorMsg, 'error');
                        }
                    } catch (err) {
                        Swal.fire('Błąd!', 'Otrzymano nieprawidłową odpowiedź z serwera.', 'error');
                    }
                };
                xhr.onerror = () => Swal.fire('Błąd Sieci!', 'Nie można było wysłać formularza.', 'error');
                xhr.send(formData);
            });
        });
    </script>
@endpush
