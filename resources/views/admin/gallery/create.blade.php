@extends('layouts.app')
@section('header_title', 'Dodaj nową galerię')

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
            border: 1px solid #eee;
        }

        .remove-img-btn {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 22px;
            height: 22px;
            background-color: #dc3545;
            color: white;
            border: 1px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            line-height: 1;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .remove-img-btn:hover {
            transform: scale(1.1);
        }

        .progress-wrapper {
            display: none;
        }

        /* Ukrywamy kontener paska postępu domyślnie */
    </style>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Nowa galeria</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Wystąpiły błędy:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data"
                        id="galleryForm">
                        @csrf
                        <div class="mb-3"><label for="title" class="form-label">Tytuł galerii*</label><input
                                type="text" id="title" name="title" class="form-control"
                                value="{{ old('title') }}" required maxlength="65"></div>
                        <div class="mb-3"><label for="description" class="form-label">Opis galerii*</label>
                            <textarea id="description" name="description"  style="min-height: 240px !important"  class="form-control" rows="4" required>{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3"><label for="images" class="form-label">Wybierz zdjęcia* (.png, .jpg,
                                .jpeg)</label><input type="file" name="images[]" id="images" class="form-control"
                                multiple required accept="image/png,image/jpeg,image/jpg"></div>

                        <div id="preview-grid"></div>

                        <div class="progress-wrapper mt-3">
                            <div class="progress">
                                <div id="upload-progress-bar"
                                    class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                    style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4" id="submitBtn">Dodaj nową galerię</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('images');
            const previewGrid = document.getElementById('preview-grid');
            const galleryForm = document.getElementById('galleryForm');
            const submitBtn = document.getElementById('submitBtn');
            const progressWrapper = document.querySelector('.progress-wrapper');
            const progressBar = document.getElementById('upload-progress-bar');

            // Ten obiekt będzie przechowywał naszą listę plików, którą możemy modyfikować
            const dataTransfer = new DataTransfer();

            imageInput.addEventListener('change', function() {
                addFiles(this.files);
            });

            function addFiles(files) {
                Array.from(files).forEach(file => dataTransfer.items.add(file));
                imageInput.files = dataTransfer.files;
                renderPreviews();
            }

            function renderPreviews() {
                previewGrid.innerHTML = '';
                Array.from(dataTransfer.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'img-preview-wrapper';
                        wrapper.innerHTML = `
                    <img src="${e.target.result}" class="img-preview" title="${file.name}">
                    <button type="button" class="remove-img-btn" data-index="${index}" title="Usuń ten plik z listy">&times;</button>
                `;
                        previewGrid.appendChild(wrapper);
                    }
                    reader.readAsDataURL(file);
                });
            }

            previewGrid.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-img-btn')) {
                    const indexToRemove = parseInt(e.target.dataset.index, 10);
                    const newFiles = new DataTransfer();
                    Array.from(dataTransfer.files).forEach((file, index) => {
                        if (index !== indexToRemove) {
                            newFiles.items.add(file);
                        }
                    });
                    dataTransfer = newFiles;
                    imageInput.files = dataTransfer.files;
                    renderPreviews();
                }
            });

            galleryForm.addEventListener('submit', function(e) {
                e.preventDefault();
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Przetwarzanie...';
                progressWrapper.style.display = 'block';

                const formData = new FormData(this);
                const xhr = new XMLHttpRequest();

                xhr.open('POST', this.action, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')
                    .getAttribute('content'));
                xhr.setRequestHeader('Accept', 'application/json');

                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        progressBar.style.width = percentComplete + '%';
                        progressBar.textContent = Math.round(percentComplete) + '%';
                    }
                });

                xhr.onload = function() {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Dodaj nową galerię';
                    progressWrapper.style.display = 'none';

                    if (xhr.status >= 200 && xhr.status < 300) {
                        Swal.fire({
                            title: 'Sukces!',
                            text: 'Nowa galeria została pomyślnie dodana.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.href = "{{ route('admin.gallery.index') }}";
                        });
                    } else {
                        const errorResponse = JSON.parse(xhr.responseText);
                        let errorMsg = 'Wystąpił błąd:\n';
                        if (errorResponse.errors) {
                            for (const field in errorResponse.errors) {
                                errorMsg += `- ${errorResponse.errors[field].join(', ')}\n`;
                            }
                        } else {
                            errorMsg = errorResponse.message || 'Nieznany błąd serwera.';
                        }
                        Swal.fire('Błąd!', errorMsg, 'error');
                    }
                };

                xhr.onerror = function() {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Dodaj nową galerię';
                    Swal.fire('Błąd sieci!',
                        'Nie można było wysłać formularza. Sprawdź połączenie z internetem.',
                        'error');
                };

                xhr.send(formData);
            });
        });
    </script>
@endpush
