<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        @yield('header_title', 'Strona główna')
                    </div>
                </div>
                <ul class="navbar-nav header-right">

                    <li class="nav-item">
                        <div class="input-group search-area d-xl-inline-flex d-none" style="position: relative;">
                            <input type="text" class="form-control" placeholder="Wyszukaj w intranecie..."
                                id="globalSearchInput" autocomplete="off">
                            <span class="input-group-text"><a href="javascript:void(0)"><i
                                        class="flaticon-381-search-2"></i></a></span>

                            {{-- Kontener na wyniki wyszukiwania --}}
                            <div id="globalSearchResults" class="dropdown-menu"
                                style="width: 100%; display: none; max-height: 400px; overflow-y: auto;">
                                {{-- Wyniki będą wstawiane tutaj przez JavaScript --}}
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown">
                            <img src="{{ Auth::user()->avatar_path ? asset('storage/' . Auth::user()->avatar_path) : asset('template/images/default_avatar.webp') }}"
                                width="20" class="rounded-circle" alt="Avatar">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item ai-icon">
                                <span class="ms-2">Profil</span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="dropdown-item ai-icon"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <span class="ms-2">Wyloguj</span>
                                </a>
                            </form>
                        </div>

                </ul>
            </div>
        </nav>
    </div>
</div>
