@extends('layouts.app')

@section('header_title', 'Edycja użytkownika: ' . $user->name)

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Formularz edycji użytkownika</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-label form-label" for="name">Imię i Nazwisko*</label>
                                        <input type="text" id="name" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-label form-label" for="username">Nazwa użytkownika*</label>
                                        <input type="text" id="username" name="username"
                                            class="form-control @error('username') is-invalid @enderror"
                                            value="{{ old('username', $user->username) }}" required>
                                        @error('username')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-label form-label" for="email">Adres Email*</label>
                                        <input type="email" id="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-label form-label" for="phone_number">Telefon</label>
                                        <input type="text" id="phone_number" name="phone_number"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            value="{{ old('phone_number', $user->phone_number) }}">
                                        @error('phone_number')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-label form-label" for="title">Stanowisko</label>
                                        <input type="text" id="title" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title', $user->title) }}">
                                        @error('title')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-label form-label" for="role">Ranga*</label>
                                        <select class="form-control @error('role') is-invalid @enderror" id="role"
                                            name="role" required>
                                            <option value="user" @selected(old('role', $user->role) == 'user')>User</option>
                                            <option value="administrator" @selected(old('role', $user->role) == 'administrator')>Administrator
                                            </option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <p>Zostaw puste, jeśli nie chcesz zmieniać hasła.</p>
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-label form-label" for="password">Nowe Hasło</label>
                                        <input type="password" id="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-label form-label" for="password_confirmation">Powtórz Nowe
                                            Hasło</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Zapisz zmiany</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
