<div class="deznav">
    <div class="deznav-scroll">
        @if (auth()->user()->role == 'administrator')
            <a href="{{ route('admin.news.create') }}" class="add-menu-sidebar">+ Dodaj nowy post</a>
        @endif
        <ul class="metismenu" id="menu">

            <li><a href="{{ route('dashboard') }}" class="ai-icon" aria-expanded="false"><i class="flaticon-381-home-2"></i><span class="nav-text">Strona główna</span></a></li>
            <li><a href="{{ route('news') }}" class="ai-icon" aria-expanded="false"><i class="flaticon-381-newspaper"></i><span class="nav-text">Aktualności</span></a></li>
            <li><a href="{{ route('gallery') }}" class="ai-icon" aria-expanded="false"><i class="flaticon-381-photo-camera-1"></i><span class="nav-text">Galeria</span></a></li>
            <li><a href="{{ route('knowledge') }}" class="ai-icon" aria-expanded="false"><i class="flaticon-381-settings-2"></i><span class="nav-text">Baza wiedzy</span></a></li>
            <li><a href="{{ route('documents') }}" class="ai-icon" aria-expanded="false"><i class="flaticon-381-file"></i><span class="nav-text">Dokumenty</span></a></li>
            <li><a href="{{ route('phonebook') }}" class="ai-icon" aria-expanded="false"><i class="flaticon-381-id-card-1"></i><span class="nav-text">Książka telefoniczna</span></a></li>
            <li><a href="{{ route('contact.create') }}" class="ai-icon" aria-expanded="false"><i class="flaticon-381-send-1"></i><span class="nav-text">Kontakt</span></a></li>

            @if (auth()->user()->role == 'administrator')
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false"><i class="flaticon-381-settings-2"></i><span class="nav-text">Panel Admina</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.news.index') }}">Zarządzaj aktualnościami</a></li>
                        <li><a href="{{ route('admin.gallery.index') }}">Zarządzaj galerią</a></li>
                        <li><a href="{{ route('admin.users.index') }}">Zarządzaj użytkownikami</a></li>
                        <li><a href="{{ route('admin.documents.index') }}">Zarządzaj dokumentami</a></li>
                        <li><a href="{{ route('admin.knowledge.index') }}">Zarządzaj bazą wiedzy</a></li>
                    </ul>
                </li>
            @endif
        </ul>
        <div class="copyright"><strong>Programowanie zaawansowanych serwisów internetowych 2025</strong> </div>
    </div>
</div>
