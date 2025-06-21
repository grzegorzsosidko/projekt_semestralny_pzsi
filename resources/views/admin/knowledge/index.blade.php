@extends('layouts.app')

@section('header_title', 'Zarządzanie Bazą Wiedzy')

@push('styles')
<style>
    .crancy-pcats__list a{letter-spacing:.025em;color:#085c9c!important;font-weight:400;font-size:12px;padding:10px 20px;border-radius:4px!important;background:#e4f5fc;}
    #faqList .list-group-item { cursor: pointer; transition: background-color 0.2s ease-in-out; }
    #faqList .list-group-item.active { background-color: #e4f5fc; border-color: #bde5f8; font-weight: bold; }
    .status-dot { font-size: 12px; }
</style>
@endpush

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Baza pytań</h4>
                        <div class="crancy-pcats__bar">
                            <div class="crancy-pcats__list list-group">
                                <a class="list-group-item btn btn-primary" href="javascript:void(0)" id="addQuestionBtn">Dodaj pytanie</a>
                                <a class="list-group-item btn btn-primary" href="javascript:void(0)" id="editQuestionBtn" disabled>Edytuj pytanie</a>
                                <a class="list-group-item btn btn-primary" href="javascript:void(0)" id="toggleQuestionBtn" disabled>Zmień status</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3"><input type="text" class="form-control" id="faqSearchInput" placeholder="Wyszukaj pytanie..."></div>
                        <div class="basic-list-group">
                            <div class="list-group" id="faqList">
                                @forelse ($faqs as $faq)
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start" data-id="{{ $faq->id }}" data-is-hidden="{{ $faq->is_hidden ? '1' : '0' }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1"><i class="fa fa-circle status-dot {{ $faq->is_hidden ? 'text-danger' : 'text-success' }} me-2"></i>{{ $faq->question }}</h5>
                                        </div>
                                        <p class="mb-1 ms-4">{{ Str::limit($faq->answer, 350) }}</p>
                                    </a>
                                @empty
                                    <p id="no-faqs-info" class="text-center">Brak pytań w bazie wiedzy.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="faqModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="faqForm">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="_method" id="faqFormMethod" value="POST">
                    <div class="mb-3">
                        <label for="faqQuestion" class="form-label">Treść pytania*</label>
                        <textarea name="question" id="faqQuestion" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="faqAnswer" class="form-label">Treść odpowiedzi*</label>
                        <textarea name="answer" id="faqAnswer" class="form-control" rows="12" required style="min-height: 150px"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary" id="saveFaqBtn">Zapisz</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Zmienne globalne modułu ---
    let selectedFaqId = null;
    let selectedIsHidden = false;

    // --- Elementy DOM ---
    const faqList = document.getElementById('faqList');
    const searchInput = document.getElementById('faqSearchInput');
    const addBtn = document.getElementById('addQuestionBtn');
    const editBtn = document.getElementById('editQuestionBtn');
    const toggleBtn = document.getElementById('toggleQuestionBtn');
    const faqModal = new bootstrap.Modal(document.getElementById('faqModal'));
    const faqModalLabel = document.getElementById('faqModalLabel');
    const faqForm = document.getElementById('faqForm');
    const faqFormMethod = document.getElementById('faqFormMethod');

    // --- Funkcje pomocnicze ---
    function updateButtonStates() {
        if (selectedFaqId) {
            editBtn.disabled = false;
            toggleBtn.disabled = false;
            toggleBtn.textContent = selectedIsHidden ? 'Odkryj pytanie' : 'Ukryj pytanie';
        } else {
            editBtn.disabled = true;
            toggleBtn.disabled = true;
            toggleBtn.textContent = 'Zmień status';
        }
    }

    // === POCZĄTEK DODANEGO KODU WYSZUKIWARKI ===
    // --- Wyszukiwarka Lokalna ---
    if (searchInput && faqList) {
        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            const items = faqList.getElementsByClassName('list-group-item');

            for (let item of items) {
                // Szukamy w całym tekście danego elementu (pytanie + odpowiedź)
                const text = item.textContent || item.innerText;
                if (text.toLowerCase().indexOf(filter) > -1) {
                    item.style.display = ""; // Pokaż element
                } else {
                    item.style.display = "none"; // Ukryj element
                }
            }
        });
    }
    // === KONIEC DODANEGO KODU WYSZUKIWARKI ===

    // --- Nasłuchiwanie na zdarzenia ---

    // Kliknięcie na element listy
    faqList.addEventListener('click', function(e) {
        const item = e.target.closest('.list-group-item');
        if (!item) return;

        // Jeśli kliknięty element był już aktywny, odznaczamy go
        if (item.classList.contains('active')) {
            item.classList.remove('active');
            selectedFaqId = null;
        } else {
            document.querySelectorAll('#faqList .list-group-item').forEach(el => el.classList.remove('active'));
            item.classList.add('active');
            selectedFaqId = item.dataset.id;
            selectedIsHidden = item.dataset.isHidden === '1';
        }
        updateButtonStates();
    });

    // Przycisk "Dodaj pytanie"
    addBtn.addEventListener('click', function() {
        faqForm.reset();
        faqModalLabel.textContent = 'Dodaj nowe pytanie';
        faqForm.action = "{{ route('admin.knowledge.store') }}";
        faqFormMethod.value = 'POST';
        faqModal.show();
    });

    // Przycisk "Edytuj pytanie"
    editBtn.addEventListener('click', function() {
        if (!selectedFaqId) return;

        fetch(`/admin/knowledge/${selectedFaqId}`)
            .then(res => res.json())
            .then(data => {
                faqForm.querySelector('#faqQuestion').value = data.question;
                faqForm.querySelector('#faqAnswer').value = data.answer;
                faqModalLabel.textContent = 'Edytuj pytanie';
                faqForm.action = `/admin/knowledge/${selectedFaqId}`;
                faqFormMethod.value = 'PATCH';
                faqModal.show();
            });
    });

    // Przycisk "Ukryj/Odkryj"
    toggleBtn.addEventListener('click', function() {
        if (!selectedFaqId) return;

        fetch(`/admin/knowledge/${selectedFaqId}/toggle-status`, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                const item = faqList.querySelector(`[data-id="${selectedFaqId}"]`);
                const icon = item.querySelector('.status-dot');
                item.dataset.isHidden = data.is_hidden ? '1' : '0';
                selectedIsHidden = data.is_hidden;
                icon.classList.toggle('text-success', !data.is_hidden);
                icon.classList.toggle('text-danger', data.is_hidden);
                updateButtonStates();
            }
        });
    });

    // Zapis formularza z modala
    faqForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const method = document.getElementById('faqFormMethod').value;

        fetch(this.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' },
            body: formData
        })
        .then(res => {
            if (!res.ok) {
                 // W przypadku błędu walidacji (422) lub innego, rzucamy błąd, aby przejść do .catch
                 return res.json().then(err => { throw err; });
            }
            return res.json();
        })
        .then(data => {
            if(data.success) {
                faqModal.hide();
                location.reload(); // Najprostszy sposób na odświeżenie listy
            }
        }).catch(err => {
            // Obsługa błędów walidacji
            if (err.errors) {
                let errorMsg = 'Wystąpiły błędy:\n';
                for (const field in err.errors) {
                    errorMsg += `- ${err.errors[field].join(', ')}\n`;
                }
                alert(errorMsg);
            } else {
                alert('Wystąpił nieznany błąd serwera.');
            }
        });
    });
});
</script>
@endpush
