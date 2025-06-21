@extends('layouts.app')

@section('header_title', 'Mój profil')

@push('styles')
    <style>
        .profile-head .cover-photo {
            background-size: cover;
            background-position: center;
            height: 350px;
            width: 100%;
        }

        .profile-photo img {
            width: 160px;
            height: 160px;
            object-fit: cover;
        }

        @media only screen and (max-width:1199px) {
            .profile-head .cover-photo {
                height: 200px;
            }

            .profile-info .profile-photo {
                width: 220px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="content-body">
        <div id="main_page">
            <div class="container-fluid">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger"><strong>Wystąpiły błędy:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-12">
                        <div class="profile card card-body px-3 pt-3 pb-0">
                            <div class="profile-head">
                                <div class="photo-content">
                                    <div class="cover-photo"
                                        style="background-image: url('{{ $user->cover_photo_path ? asset('storage/' . $user->cover_photo_path) : asset('template/images/default_cover.webp') }}');">
                                    </div>
                                </div>
                                <div class="profile-info">
                                    <div class="profile-photo" style="border:8px solid white; border-radius:50%;"><img
                                            src="{{ $user->avatar_path ? asset('storage/' . $user->avatar_path) : asset('template/images/default_avatar.webp') }}"
                                            class="img-fluid rounded-circle" alt="Avatar"></div>
                                    <div class="profile-details pt-10">
                                        <div class="profile-name px-4">
                                            <h4 class="text-primary mb-0">{{ $user->name }}</h4>
                                            <p style="margin-top:0; font-size:15px;">{{ $user->title ?? 'Brak stanowiska' }}
                                            </p>
                                        </div>
                                        <div class="profile-email px-5">
                                            <h4 class="text-muted mb-0"><a
                                                    href="mailto:{{ $user->email }}">{{ $user->email }}</a></h4>
                                            <p style="margin-top:0; font-size:15px;">Email</p>
                                        </div>
                                        <div class="profile-phone px-5">
                                            <h4 class="text-muted mb-0">{{ $user->phone_number ?? 'Brak numeru telefonu' }}
                                            </h4>
                                            <p style="margin-top:0; font-size:15px;">Telefon</p>
                                        </div>
                                        <div class="dropdown ms-auto d-flex align-items-center">
                                            <ul class="social-media">
                                                @if (!empty($user->social_links['linkedin']))
                                                    <li
                                                        style="list-style-type: none; display: inline-block; margin-left: 5px;">
                                                        <a class="icon" href="{{ $user->social_links['linkedin'] }}"
                                                            target="_blank"><i class="fab fa-linkedin"></i></a></li>
                                                @endif
                                                @if (!empty($user->social_links['facebook']))
                                                    <li
                                                        style="list-style-type: none; display: inline-block; margin-left: 5px;">
                                                        <a class="icon" href="{{ $user->social_links['facebook'] }}"
                                                            target="_blank"><i class="fab fa-facebook"></i></a></li>
                                                @endif
                                                @if (!empty($user->social_links['instagram']))
                                                    <li
                                                        style="list-style-type: none; display: inline-block; margin-left: 5px;">
                                                        <a class="icon" href="{{ $user->social_links['instagram'] }}"
                                                            target="_blank"><i class="fab fa-instagram"></i></a></li>
                                                @endif
                                            </ul>
                                            <a class="btn btn-primary light sharp ms-3" data-bs-toggle="dropdown"
                                                aria-expanded="true"><svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                    height="18px" viewBox="0 0 24 24">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                        <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                        <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                                    </g>
                                                </svg></a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="javascript:void(0)" class="dropdown-item"
                                                        data-bs-toggle="modal" data-bs-target="#zmiana_zdjecia_avatar"><i
                                                            class="fa fa-camera text-primary"
                                                            style="margin-right: 10px"></i> Zmień zdjęcie profilowe</a></li>
                                                <li><a href="javascript:void(0)" class="dropdown-item"
                                                        data-bs-toggle="modal" data-bs-target="#zmiana_zdjecia_cover"><i
                                                            class="fa fa-image text-primary" style="margin-right: 10px"></i>
                                                        Zmień zdjęcie tła</a></li>
                                                <hr>
                                                <li><a href="javascript:void(0)" class="dropdown-item"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#zmiana-informacje-kontaktowe"><i
                                                            class="fa fa-phone text-primary" style="margin-right: 10px"></i>
                                                        Edytuj info kontaktowe</a></li>
                                                <li><a href="javascript:void(0)" class="dropdown-item"
                                                        data-bs-toggle="modal" data-bs-target="#edycja-profilu"><i
                                                            class="fa fa-user text-primary" style="margin-right: 10px"></i>
                                                        Edytuj profil (bio, social)</a></li>
                                                <hr>
                                                <li><a href="javascript:void(0)" class="dropdown-item"
                                                        data-bs-toggle="modal" data-bs-target="#zmiana-hasla"><i
                                                            class="fa fa-key text-primary" style="margin-right: 10px"></i>
                                                        Zmiana hasła logowania</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card h-auto">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <div class="my-post-content pt-3">
                                            <div class="profile-uoloaded-post border-bottom-1 pb-3">
                                                <h5 class="text-primary d-inline">O mnie</h5>
                                                <p class="mt-2">
                                                    {{ $user->bio ?? 'Brak opisu bio. Opowiedz coś o sobie!' }}</p>
                                            </div>
                                            <div class="profile-uoloaded-post border-bottom-1 py-3">
                                                <h5 class="text-primary d-inline">Zainteresowania</h5>
                                                <p class="mt-2">
                                                    {{ $user->interests ?? 'Brak informacji o zainteresowaniach.' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="zmiana_zdjecia_avatar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Zmień zdjęcie profilowe</h5><button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Wybierz nowy plik awatara. Zostanie automatycznie przycięty do kwadratu.</p>
                        <input type="file" name="avatar" class="form-control" required>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Anuluj</button><button type="submit" class="btn btn-primary">Zapisz
                            awatar</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="zmiana_zdjecia_cover">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('profile.cover.update') }}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Zmień zdjęcie w tle</h5><button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Wybierz plik (max. 8MB).</p><input type="file" name="cover" class="form-control"
                            required>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Anuluj</button><button type="submit" class="btn btn-primary">Zapisz
                            zdjęcie</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="zmiana-informacje-kontaktowe">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('profile.contact.update') }}" method="POST">@csrf @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title">Edytuj informacje kontaktowe</h5><button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Adres e-mail (login)</label><input type="email"
                                name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="mb-3"><label class="form-label">Numer telefonu</label><input type="text"
                                name="phone_number" class="form-control"
                                value="{{ old('phone_number', $user->phone_number) }}"></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Anuluj</button><button type="submit" class="btn btn-primary">Zapisz
                            zmiany</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edycja-profilu">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('profile.details.update') }}" method="POST">@csrf @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title">Edytuj profil</h5><button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Tytuł / Stanowisko</label><input type="text"
                                name="title" class="form-control" value="{{ old('title', $user->title) }}"></div>
                        <div class="mb-3"><label class="form-label">O mnie</label>
                            <textarea name="bio" class="form-control" rows="3">{{ old('bio', $user->bio) }}</textarea>
                        </div>
                        <div class="mb-3"><label class="form-label">Zainteresowania</label>
                            <textarea name="interests" class="form-control" rows="2">{{ old('interests', $user->interests) }}</textarea>
                        </div>
                        <hr>
                        <h5>Social Media</h5>
                        <div class="input-group mb-3"><span class="input-group-text"><i
                                    class="fab fa-linkedin"></i></span><input type="url"
                                name="social_links[linkedin]" class="form-control" placeholder="Link do profilu LinkedIn"
                                value="{{ old('social_links.linkedin', $user->social_links['linkedin'] ?? '') }}"></div>
                        <div class="input-group mb-3"><span class="input-group-text"><i
                                    class="fab fa-facebook"></i></span><input type="url"
                                name="social_links[facebook]" class="form-control" placeholder="Link do profilu Facebook"
                                value="{{ old('social_links.facebook', $user->social_links['facebook'] ?? '') }}"></div>
                        <div class="input-group mb-3"><span class="input-group-text"><i
                                    class="fab fa-instagram"></i></span><input type="url"
                                name="social_links[instagram]" class="form-control"
                                placeholder="Link do profilu Instagram"
                                value="{{ old('social_links.instagram', $user->social_links['instagram'] ?? '') }}"></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Anuluj</button><button type="submit" class="btn btn-primary">Zapisz
                            zmiany</button></div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal zmiany hasła, który używa partiala z Breeze --}}
    <div class="modal fade" id="zmiana-hasla">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Zmiana hasła</h5><button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">@include('profile.partials.update-password-form')</div>
            </div>
        </div>
    </div>
@endsection
