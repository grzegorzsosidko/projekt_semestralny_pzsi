@extends('layouts.app')

@section('header_title', 'Zarządzanie dokumentami')

@push('styles')
<style>
    /* Style dla przycisków w nagłówku karty */
    .crancy-pcats__list{display:flex;align-items:center;flex-direction:initial;gap:16px}.crancy-pcats__list a{letter-spacing:.025em;color:#085c9c!important;font-weight:400;font-size:12px;position:relative;margin:0;border:none;line-height:initial;padding:10px 20px;border-radius:4px!important;background:#e4f5fc;display:flex;align-items:center;gap:5px}

    /* Style dla sortowalnych nagłówków tabeli */
    th.sortable { cursor: pointer; user-select: none; }
    th.sortable:hover { background-color: #f0f0f0; }
    th .arrow { font-size: 0.8em; margin-left: 5px; color: #999; display: inline-block; }
</style>
@endpush

@section('content')
<div class="content-body">
    <div class="container-fluid">
        {{-- Komunikaty o statusie (np. po pomyślnym usunięciu) --}}
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- Komunikaty o błędach --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Informacje o dostępnych dokumentach</h4>
                        <div class="crancy-pcats__bar">
                            <div class="crancy-pcats__list list-group">
                                <a class="list-group-item btn btn-secondary btn-xs" href="{{ route('admin.documents.create') }}">Dodaj dokument</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="text" id="searchInput" class="form-control w-25" placeholder="Szukaj w tabeli...">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-responsive-md" id="documentsTable">
                                <thead>
                                    <tr>
                                        <th class="sortable" data-col="0">Nazwa dokumentu <span class="arrow"></span></th>
                                        <th class="sortable" data-col="1">Kategoria <span class="arrow"></span></th>
                                        <th class="sortable" data-col="2">Załączniki <span class="arrow"></span></th>
                                        <th class="sortable" data-col="3">Data dodania <span class="arrow"></span></th>
                                        <th class="sortable" data-col="4">Dodane przez <span class="arrow"></span></th>
                                        <th>Status</th>
                                        <th>Akcja</th>
                                    </tr>
                                </thead>
                                <tbody id="documentsTbody">
                                    @forelse($documents as $doc)
                                    <tr>
                                        <td><strong>{{ $doc->title }}</strong></td>
                                        <td>{{ $doc->category->name }}</td>
                                        <td>{{ $doc->files->count() }}</td>
                                        <td>{{ $doc->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $doc->user->name }}</td>
                                        <td>
                                            @if($doc->status == 'published')
                                                <div class="d-flex align-items-center"><i class="fa fa-circle text-success me-1"></i> Opublikowany</div>
                                            @else
                                                <div class="d-flex align-items-center"><i class="fa fa-circle text-danger me-1"></i> Ukryty</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <button class="dropdown-item view-attachments-btn" data-doc-id="{{ $doc->id }}">Podgląd załączników</button>
                                                    <a class="dropdown-item" href="{{ route('admin.documents.edit', $doc) }}">Edytuj zawartość</a>
                                                    <form action="{{ route('admin.documents.toggle-status', $doc) }}" method="POST" class="d-inline">@csrf @method('PATCH') <button type="submit" class="dropdown-item">{{ $doc->status == 'published' ? 'Ukryj dokument' : 'Opublikuj dokument' }}</button></form>
                                                    <button class="dropdown-item text-danger delete-document-btn" data-action="{{ route('admin.documents.destroy', $doc) }}">Usuń dokument</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="7" class="text-center">Brak dokumentów w systemie.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('admin.documents.export') }}" class="btn btn-success mt-3" style="width: 150px;">Eksportuj do CSV</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="attachmentsModal" tabindex="-1" aria-labelledby="attachmentsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attachmentsModalTitle">Załączniki</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="attachmentsModalList">
                    </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Potwierdź usunięcie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Czy na pewno chcesz usunąć ten dokument i wszystkie jego załączniki? Tej operacji nie można cofnąć.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Tak, usuń</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Inicjalizacja Modali ---
    const attachmentsModal = new bootstrap.Modal(document.getElementById('attachmentsModal'));
    const attachmentsModalTitle = document.getElementById('attachmentsModalTitle');
    const attachmentsModalList = document.getElementById('attachmentsModalList');

    const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
    const deleteForm = document.getElementById('deleteForm');

    // --- Logika dla przycisków akcji ---
    document.querySelector('#documentsTbody').addEventListener('click', function(e) {
        const targetButton = e.target.closest('button');
        if (!targetButton) return;

        // Podgląd załączników
        if (targetButton.classList.contains('view-attachments-btn')) {
            e.preventDefault();
            const docId = targetButton.dataset.docId;
            attachmentsModalList.innerHTML = '<li class="list-group-item">Ładowanie...</li>';
            attachmentsModal.show();

            fetch(`/admin/documents/${docId}/attachments`)
                .then(response => response.json())
                .then(data => {
                    attachmentsModalTitle.textContent = `Załączniki dla: ${data.title}`;
                    attachmentsModalList.innerHTML = '';
                    if (data.files && data.files.length > 0) {
                        data.files.forEach(file => {
                            const li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.innerHTML = `<a href="${file.url}" target="_blank">${file.name}</a>`;
                            attachmentsModalList.appendChild(li);
                        });
                    } else {
                        attachmentsModalList.innerHTML = '<li class="list-group-item">Brak załączników.</li>';
                    }
                })
                .catch(err => {
                    attachmentsModalList.innerHTML = '<li class="list-group-item text-danger">Nie udało się załadować załączników.</li>';
                });
        }

        // Potwierdzenie usunięcia
        if (targetButton.classList.contains('delete-document-btn')) {
            e.preventDefault();
            const action = targetButton.dataset.action;
            deleteForm.action = action;
            deleteModal.show();
        }
    });

    // --- Wyszukiwarka Lokalna ---
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('documentsTbody');
    if (searchInput && tableBody) {
        const rows = tableBody.getElementsByTagName('tr');
        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            for (let row of rows) {
                let text = row.textContent || row.innerText;
                if (text.toLowerCase().indexOf(filter) > -1) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        });
    }

    // --- Sortowanie Tabeli ---
    const sortableHeaders = document.querySelectorAll('#documentsTable th.sortable');
    sortableHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const table = this.closest('table');
            const tbody = table.querySelector('tbody');
            const colIndex = parseInt(this.getAttribute('data-col'));
            const currentOrder = this.getAttribute('data-order') || 'desc';
            const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';

            sortableHeaders.forEach(h => {
                h.removeAttribute('data-order');
                h.querySelector('.arrow').textContent = '';
            });

            this.setAttribute('data-order', newOrder);
            this.querySelector('.arrow').textContent = newOrder === 'asc' ? '▲' : '▼';

            Array.from(tbody.querySelectorAll('tr'))
                .sort((a, b) => {
                    let cellA = a.cells[colIndex] ? a.cells[colIndex].textContent.trim().toLowerCase() : '';
                    let cellB = b.cells[colIndex] ? b.cells[colIndex].textContent.trim().toLowerCase() : '';

                    // Specjalna obsługa dla dat w formacie YYYY-MM-DD
                    if (colIndex === 3) {
                        cellA = new Date(a.cells[colIndex].textContent.trim()).getTime() || 0;
                        cellB = new Date(b.cells[colIndex].textContent.trim()).getTime() || 0;
                    } else if (!isNaN(cellA) && !isNaN(cellB) && cellA.trim() !== '' && cellB.trim() !== '') {
                        cellA = parseFloat(cellA);
                        cellB = parseFloat(cellB);
                    }

                    if (cellA < cellB) return newOrder === 'asc' ? -1 : 1;
                    if (cellA > cellB) return newOrder === 'asc' ? 1 : -1;
                    return 0;
                })
                .forEach(row => tbody.appendChild(row));
        });
    });
});
</script>
@endpush
