<x-guest-layout-custom>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf <div class="form-group">
            <label class="mb-1 text-white" for="email"><strong>Adres E-mail</strong></label>
            <input type="email" class="form-control" id="email" name="email" :value="old('email')" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
        </div>

        <div class="form-group">
            <label class="mb-1 text-white" for="password"><strong>Hasło</strong></label>
            <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
        </div>

        <div class="row d-flex justify-content-between mt-4 mb-2">
            <div class="form-group">
                <div class="form-check custom-checkbox ms-1 text-white">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">Zapamiętaj dane logowania</label>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn bg-white text-primary btn-block">Zaloguj się</button>
        </div>
    </form>

</x-guest-layout-custom>
