<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('template/images/favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/images/favicon.png') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">

    <link href="{{ asset('template/models/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('template/models/vendor/toastr/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/models/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('template/models/css/style.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('template/models/css/add_style.css') }}" rel="stylesheet" media="screen">

    <link href="{{ asset('template/models/css/cropper.css') }}" rel="stylesheet">

    @vite(['resources/js/app.js'])
    @stack('styles')


    @if (request()->routeIs('dashboard'))
        <style>
            .banner-card {
                padding: 45px 50px;
                font-size: 17px
            }

            .section-title h2,
            .section-title .h2 {
                font-size: 36px
            }

            @media only screen and (min-width:368px) and (max-width:1199px) {
                .main-banner-area {
                    padding: 25px 15px 0 15px
                }

                .main-banner-content h1,
                .main-banner-content .h1 {
                    font-size: 55px
                }

                .main-banner-area {
                    padding-top: 25px
                }

                .download-area {
                    padding: 80px 10px
                }

                .section-heading h2,
                .section-heading .h2 {
                    font-size: 35px
                }

                .section-title h2,
                .section-title .h2 {
                    font-size: 26px;
                    padding: 0 20px
                }

                .main-banner-area .info p {
                    margin-bottom: 30px
                }

                .mt-3 {
                    margin-top: 0 !important
                }
            }

            @media only screen and (min-width:1350px) and (max-width:1450px) {

                .main-banner-content h1,
                .main-banner-content .h1 {
                    font-size: 65px
                }

                .main-banner-content {
                    margin-left: 50px
                }

                .info {
                    padding-right: 70px
                }

                .disabled_1350px_1450px {
                    display: none !important
                }

                .main-banner-area .info p {
                    font-size: 15px
                }

                .banner-card p {
                    font-size: 14px
                }

                .main-banner-area {
                    padding-top: 25px
                }
            }
        </style>
    @endif

    @stack('styles')
</head>

<body>
    <div id="main-wrapper" class="show">

        @include('layouts.partials.nav-header')

        @include('layouts.partials.header')

        @include('layouts.partials.sidebar')

        @yield('content')

        @include('layouts.partials.footer')

    </div>

    <script src="{{ asset('template/models/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('template/models/js/deznav-init.js') }}"></script>
    <script src="{{ asset('template/models/js/custom.js') }}"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('globalSearchInput');
            const resultsContainer = document.getElementById('globalSearchResults');
            let debounceTimer;

            if (searchInput && resultsContainer) {
                searchInput.addEventListener('keyup', function() {
                    clearTimeout(debounceTimer);
                    const query = this.value;

                    if (query.length < 3) {
                        resultsContainer.style.display = 'none';
                        return;
                    }

                    debounceTimer = setTimeout(() => {
                        resultsContainer.innerHTML =
                            '<a class="dropdown-item" href="#">Wyszukiwanie...</a>';
                        resultsContainer.style.display = 'block';

                        fetch(`{{ route('global.search') }}?q=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                resultsContainer.innerHTML = ''; // Wyczyść "Wyszukiwanie..."
                                if (data.length > 0) {
                                    data.forEach(item => {
                                        const a = document.createElement('a');
                                        a.href = item.url;
                                        a.className = 'dropdown-item';
                                        a.innerHTML = `
                                            <div class="d-flex justify-content-between">
                                                <span>${item.title}</span>
                                                <span class="badge badge-primary light">${item.type}</span>
                                            </div>
                                        `;
                                        resultsContainer.appendChild(a);
                                    });
                                } else {
                                    resultsContainer.innerHTML =
                                        '<span class="dropdown-item-text text-muted">Brak wyników.</span>';
                                }
                            })
                            .catch(error => {
                                console.error('Błąd wyszukiwania:', error);
                                resultsContainer.innerHTML =
                                    '<span class="dropdown-item-text text-danger">Błąd wyszukiwania.</span>';
                            });
                    }, 300); // Czeka 300ms po zaprzestaniu pisania
                });

                // Ukryj wyniki po kliknięciu gdziekolwiek indziej
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target)) {
                        resultsContainer.style.display = 'none';
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
