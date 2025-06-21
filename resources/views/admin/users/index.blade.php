@extends('layouts.app')

@section('header_title', 'Zarządzanie użytkownikami')

@push('styles')
<style>
    .crancy-pcats__list{display:flex;align-items:center;flex-direction:initial;gap:16px}.crancy-pcats__list a{letter-spacing:.025em;color:#085c9c!important;font-weight:400;font-size:12px;position:relative;margin:0;border:none;line-height:initial;padding:10px 20px;border-radius:4px!important;background:#e4f5fc;display:flex;align-items:center;gap:5px}
    th.sortable { cursor: pointer; user-select: none; }
    th.sortable:hover { background-color: #f0f0f0; }
    th .arrow { font-size: 0.8em; margin-left: 5px; color: #999; }
</style>
@endpush

@section('content')
<div class="content-body">
    <div class="container-fluid">
        @if (session('status'))<div class="alert alert-success" role="alert">{{ session('status') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Lista użytkowników</h4>
                        <div class="crancy-pcats__bar">
                            <div class="crancy-pcats__list list-group">
                                <a class="list-group-item btn btn-secondary btn-xs" href="{{ route('admin.users.create') }}">Dodaj użytkownika</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3"><input type="text" id="searchInput" class="form-control w-25" placeholder="Szukaj w tabeli..."></div>
                        <div class="table-responsive">
                            <table class="table table-responsive-md" id="usersTable">
                                <thead>
                                    <tr>
                                        <th class="sortable" data-col="0">Imię i Nazwisko <span class="arrow"></span></th>
                                        <th class="sortable" data-col="1">Nazwa użytkownika <span class="arrow"></span></th>
                                        <th class="sortable" data-col="2">Email <span class="arrow"></span></th>
                                        <th class="sortable" data-col="3">Telefon <span class="arrow"></span></th>
                                        <th class="sortable" data-col="4">Utworzony <span class="arrow"></span></th>
                                        <th>Status</th>
                                        <th class="sortable" data-col="6">Stanowisko <span class="arrow"></span></th>
                                        <th>Ranga</th>
                                        <th>Akcja</th>
                                    </tr>
                                </thead>
                                <tbody id="usersTbody">
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $user->avatar_path ? asset('storage/' . $user->avatar_path) : asset('template/images/default_avatar.webp') }}" class="rounded-circle" width="35" alt="">
                                                    <p class="m-0 ms-3">{{ $user->name }}</p>
                                                </div>
                                            </td>
                                            <td>{{ $user->username ?? 'Brak' }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone_number ?? 'Brak' }}</td>
                                            <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                            <td>@if($user->blocked_at)<span class="badge light badge-danger">Zablokowany</span>@else<span class="badge light badge-success">Aktywny</span>@endif</td>
                                            <td>{{ $user->title ?? 'Brak' }}</td>
                                            <td>@if($user->role == 'administrator')<span class="badge light badge-danger">{{ ucfirst($user->role) }}</span>@else<span class="badge light badge-primary">{{ ucfirst($user->role) }}</span>@endif</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary shadow btn-xs sharp me-1" title="Edytuj"><i class="fas fa-pencil-alt"></i></a>
                                                    @if (Auth::id() !== $user->id)
                                                        <form action="{{ route('admin.users.toggle-block', $user) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-xs sharp {{ $user->blocked_at ? 'btn-success' : 'btn-danger' }}" title="{{ $user->blocked_at ? 'Odblokuj' : 'Zablokuj' }}">
                                                                <i class="fa {{ $user->blocked_at ? 'fa-lock-open' : 'fa-lock' }}"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="9" class="text-center">Brak użytkowników w bazie danych.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                         <a href="{{ route('admin.users.export') }}" class="btn btn-success mt-3">Eksportuj do CSV</a>
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
    // Wyszukiwanie lokalne
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('usersTbody');
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

    // Sortowanie tabeli
    const sortableHeaders = document.querySelectorAll('#usersTable th.sortable');
    sortableHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const table = this.closest('table');
            const tbody = table.querySelector('tbody');
            const colIndex = parseInt(this.getAttribute('data-col'));
            const currentOrder = this.getAttribute('data-order') || 'desc';
            const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';

            // Resetuj atrybuty i strzałki dla wszystkich nagłówków
            sortableHeaders.forEach(h => {
                h.removeAttribute('data-order');
                h.querySelector('.arrow').textContent = '';
            });

            // Ustaw nowy porządek i strzałkę dla klikniętego nagłówka
            this.setAttribute('data-order', newOrder);
            this.querySelector('.arrow').textContent = newOrder === 'asc' ? '▲' : '▼';

            // Sortuj wiersze
            Array.from(tbody.querySelectorAll('tr'))
                .sort((a, b) => {
                    let aText = a.cells[colIndex].textContent.trim().toLowerCase();
                    let bText = b.cells[colIndex].textContent.trim().toLowerCase();

                    if (!isNaN(Date.parse(aText)) && !isNaN(Date.parse(bText))) {
                        // Sortowanie dat
                        aText = new Date(aText.split('-').reverse().join('-'));
                        bText = new Date(bText.split('-').reverse().join('-'));
                    } else if (!isNaN(aText) && !isNaN(bText)) {
                        // Sortowanie liczb
                        aText = parseFloat(aText);
                        bText = parseFloat(bText);
                    }

                    if (aText < bText) return newOrder === 'asc' ? -1 : 1;
                    if (aText > bText) return newOrder === 'asc' ? 1 : -1;
                    return 0;
                })
                .forEach(row => tbody.appendChild(row));
        });
    });
});
</script>
@endpush
