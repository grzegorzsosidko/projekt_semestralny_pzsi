@extends('layouts.app')

@section('header_title', 'Dodaj nowy dokument')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Nowy dokument</h4>
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

                        <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Tytuł dokumentu*</label>
                                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                                @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Opis dokumentu*</label>
                                <textarea id="description" name="description" style="min-height: 120px !important" class="form-control @error('description') is-invalid @enderror"  required>{{ old('description') }} </textarea>
                                @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="doc_category_id" class="form-label">Kategoria*</label>
                                <select id="doc_category_id" name="doc_category_id" class="form-control @error('doc_category_id') is-invalid @enderror" required>
                                    <option value="">Wybierz kategorię...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('doc_category_id') == $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('doc_category_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="attachments" class="form-label">Załączniki* (max 5)</label>
                                <input type="file" id="attachments" name="attachments[]" class="form-control @error('attachments') is-invalid @enderror" multiple>
                                @error('attachments') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                @error('attachments.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div id="attachments-list-container" class="mt-3" style="display: none;">
                                <h6>Wybrane pliki:</h6>
                                <ul id="attachmentsList" class="list-group">
                                    </ul>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4">Zapisz dokument</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('attachments');
    const attachmentsListContainer = document.getElementById('attachments-list-container');
    const attachmentsList = document.getElementById('attachmentsList');

    // Używamy obiektu DataTransfer do przechowywania listy plików,
    // ponieważ standardowa lista z inputa jest tylko do odczytu.
    let dataTransfer = new DataTransfer();

    fileInput.addEventListener('change', function(e) {
        // Dodaj nowe pliki do naszej listy
        for (let i = 0; i < this.files.length; i++) {
            dataTransfer.items.add(this.files[i]);
        }

        // Zaktualizuj pliki w inpucie i odśwież widok listy
        this.files = dataTransfer.files;
        updateAttachmentsListView();
    });

    function updateAttachmentsListView() {
        attachmentsList.innerHTML = ''; // Wyczyść starą listę

        if (dataTransfer.files.length > 0) {
            attachmentsListContainer.style.display = 'block';
        } else {
            attachmentsListContainer.style.display = 'none';
        }

        for (let i = 0; i < dataTransfer.files.length; i++) {
            const file = dataTransfer.files[i];

            // Stwórz element li dla każdego pliku
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
            listItem.textContent = file.name;

            // Stwórz przycisk "Usuń"
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-sm btn-danger';
            removeBtn.textContent = 'Usuń';

            // Dodajemy event do przycisku usuwania
            removeBtn.onclick = function() {
                removeAttachment(i);
            };

            listItem.appendChild(removeBtn);
            attachmentsList.appendChild(listItem);
        }
    }

    function removeAttachment(index) {
        // Stwórz nową listę plików bez usuniętego elementu
        let newFiles = new DataTransfer();
        for (let i = 0; i < dataTransfer.files.length; i++) {
            if (i !== index) {
                newFiles.items.add(dataTransfer.files[i]);
            }
        }

        // Podmień starą listę na nową
        dataTransfer = newFiles;

        // Zaktualizuj pliki w inpucie i odśwież widok listy
        fileInput.files = dataTransfer.files;
        updateAttachmentsListView();
    }
});
</script>
@endpush
