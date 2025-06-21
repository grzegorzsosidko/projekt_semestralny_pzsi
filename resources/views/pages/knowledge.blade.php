@extends('layouts.app')

@section('header_title', 'Baza Wiedzy')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-block">
                        <h4 class="card-title" style="text-transform: none;">Najczęściej zadawane pytania</h4>
                        <div class="mt-3 mb-2">
                            <input type="text" id="faqSearchInput" placeholder="Wyszukaj w pytaniach i odpowiedziach..." class="form-control">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="accordion accordion-primary" id="faqAccordion">
                            @forelse ($faqs as $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}">
                                            {{ $faq->question }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            {!! nl2br(e($faq->answer)) !!}
                                            <hr style='margin: 0.5rem 0 0 0;'>
                                            <small style='color:#888; font-size: 10px'>
                                                Odpowiedź opublikowana przez {{ $faq->user->name ?? 'Administrator' }} dnia {{ $faq->created_at->format('d-m-Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center p-4">Obecnie nie ma żadnych pytań w bazie wiedzy.</p>
                            @endforelse
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
    const searchInput = document.getElementById('faqSearchInput');
    const accordion = document.getElementById('faqAccordion');
    const items = accordion.getElementsByClassName('accordion-item');

    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();

        for (let i = 0; i < items.length; i++) {
            let item = items[i];
            let text = item.textContent || item.innerText;

            if (text.toLowerCase().indexOf(filter) > -1) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        }
    });
});
</script>
@endpush
