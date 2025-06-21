@extends('layouts.app')
@section('header_title', 'Formularz Kontaktowy')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header"><h4 class="card-title">Zgłoś sprawę</h4></div>
                    <div class="card-body">
                        @if(session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategoria zgłoszenia*</label>
                                <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="">Wybierz z listy...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Dokładny opis zgłoszenia*</label>
                                <textarea name="message" id="message" style="min-height: 350px !important" class="form-control @error('message') is-invalid @enderror" rows="6" required minlength="35">{{ old('message') }}</textarea>
                                <small class="form-text text-muted">Pozostało znaków: <span id="char-counter">35</span></small>
                                @error('message') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="attachments" class="form-label">Załączniki (opcjonalnie)</label>
                                <input type="file" name="attachments[]" id="attachments" class="form-control @error('attachments.*') is-invalid @enderror" multiple>
                                @error('attachments.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Wyślij zgłoszenie</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const messageArea = document.getElementById('message');
    const charCounter = document.getElementById('char-counter');
    const minLength = 35;

    messageArea.addEventListener('input', function() {
        let remaining = minLength - this.value.length;
        if (remaining < 0) remaining = 0;
        charCounter.textContent = remaining;
    });
</script>
@endpush
