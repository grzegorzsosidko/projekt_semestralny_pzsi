phonebook.blade.php
@extends('layouts.app')

@section('header_title', 'Dane kontaktowe')

@push('styles')
    <style>
        th.sortable {
            cursor: pointer;
            user-select: none;
        }

        th.sortable .arrow {
            display: inline-block;
            width: 1em;
            text-align: center;
        }

        #contactsTable {
            border-collapse: separate;
            border-spacing: 0 5px;
        }

        #contactsTable tbody tr {
            border-bottom: 1px solid #eee;
        }

        .table-hover>tbody>tr:hover {
            --bs-table-hover-bg: #f5f5f5;
        }

        .avatar-name-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Ukrywamy domyślną tabelę na mobile i pokazujemy specjalne pola */
        .mobile-card-info {
            display: none;
        }

        @media (max-width: 800px) {
            #contactsTable thead {
                display: none;
            }

            #contactsTable tbody,
            #contactsTable tr,
            #contactsTable td {
                display: block;
                width: 100%;
            }

            #contactsTable tr {
                margin-bottom: 1rem;
                padding-bottom: 1rem;
                border-bottom: 2px solid #eee;
            }

            #contactsTable td:not(:first-child) {
                display: none;
            }

            /* Ukrywamy oryginalne komórki poza pierwszą */
            #contactsTable td:first-child {
                padding: 0;
            }

            .mobile-card-info {
                display: block;
                padding-left: 50px;
            }

            .mobile-card-info .position {
                margin-top: -10px;
                font-style: italic;
                color: #555;
                margin-bottom: 5px;
            }

            .mobile-card-info a {
                display: block;
                margin-bottom: 5px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Książka adresowa</h4>
                            <div class="crancy-pcats__bar">
                                <div class="crancy-pcats__list list-group">
                                    <a class="list-group-item btn btn-success" href="{{ route('phonebook.export') }}">
                                        Eksportuj do .csv
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="mt-3 mb-3"><input type="text" id="searchInput"
                                    placeholder="Wyszukaj po imieniu, nazwisku, stanowisku lub mailu..."
                                    class="form-control"></div>

                            <div class="table-responsive">

                                <table class="table table-hover" id="contactsTable">
                                    <thead>
                                        <tr>
                                            <th class="sortable" data-col="0">Imię i nazwisko <span class="arrow"></span>
                                            </th>
                                            <th class="sortable" data-col="1">Stanowisko <span class="arrow"></span></th>
                                            <th class="sortable" data-col="2">Adres e-mail <span class="arrow"></span>
                                            </th>
                                            <th>Telefon</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contactsBody">
                                        @forelse ($users as $user)
                                            <tr>
                                                <td>
                                                    <div class="avatar-name-wrapper">
                                                        <img class="rounded-circle" width="40"
                                                            src="{{ $user->avatar_path ? asset('storage/' . $user->avatar_path) : asset('template/images/default_avatar.webp') }}"
                                                            alt="avatar">
                                                        <strong class="text-black">{{ $user->name }}</strong>
                                                    </div>
                                                    {{-- Informacje widoczne tylko na mobile --}}
                                                    <div class="mobile-card-info">
                                                        <div class="position">{{ $user->title ?? 'Brak stanowiska' }}</div>
                                                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                                        <a
                                                            href="tel:{{ $user->phone_number }}">{{ $user->phone_number ?? '' }}</a>
                                                    </div>
                                                </td>
                                                <td>{{ $user->title ?? 'Brak stanowiska' }}</td>
                                                <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                                <td><a
                                                        href="tel:{{ $user->phone_number }}">{{ $user->phone_number ?? '' }}</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Brak użytkowników do wyświetlenia.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

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
            // --- Wyszukiwarka ---
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('contactsBody');
            if (searchInput && tableBody) {
                const rows = tableBody.getElementsByTagName('tr');
                searchInput.addEventListener('keyup', function() {
                    const filter = searchInput.value.toLowerCase();
                    for (let row of rows) {
                        let text = row.textContent || row.innerText;
                        row.style.display = text.toLowerCase().indexOf(filter) > -1 ? "" : "none";
                    }
                });
            }

            // --- Sortowanie ---
            const sortableHeaders = document.querySelectorAll('#contactsTable th.sortable');
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
                            let cellA = a.cells[colIndex] ? a.cells[colIndex].textContent.trim()
                                .toLowerCase() : '';
                            let cellB = b.cells[colIndex] ? b.cells[colIndex].textContent.trim()
                                .toLowerCase() : '';

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
