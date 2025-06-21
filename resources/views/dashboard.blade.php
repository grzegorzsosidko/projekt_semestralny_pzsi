@extends('layouts.app')

@section('header_title', 'Strona główna')

@section('content')



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

<div class="content-body">
    <div id="main_page">

        <div class="main-banner-area overflow-hidden position-relative">
            <div class="container side-padding" style="max-width: 1300px">
                <div class="row align-items-center">

                    <div class="col-xl-7 col-lg-12" data-cues="slideInRight" data-duration="800">
                        <div class="main-banner-content" id="main_page_banner_content">
                            <span class="sub-t" id="main_page_banner_subtitle">CENTRUM INFORMACJI</span>
                            <h1 id="main_page_banner_title">Twoje Centrum Informacji i Współpracy</h1>
                        </div>
                    </div>

                    <div class="col-xl-5 col-lg-12" data-cues="slideInLeft" data-duration="800">
                        <div class="info mt-40" id="main_page_banner_paragraph">
                            <p>Znajdziesz tu najnowsze aktualności, ważne dokumenty, kontakty do współpracowników oraz wszelkie niezbędne zasoby do efektywnej pracy. Korzystaj regularnie, aby być na bieżąco i wspierać naszą wspólną działalność.<br><br><b>Zacznij od uzupełnienia danych swojego profilu</b>, wszystkie informacje zrobisz klikając w przycisk poniżej</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="card-area">
            <div class="container-fluid side-padding">
                <div class="row g-4 justify-content-center" data-cues="slideInUp" data-duration="800">

                    <div class="col-xl-4 col-lg-6 col-md-6" id="main_page_card_1">
                        <div class="banner-card part-two bg-color-ffffff radius-30 position-relative">
                            <h3>Szeroka baza informacyjna</h3>
                            <p class="mb-0">Szybko znajdź dane kontaktowe oraz dokumenty firmy w jednym miejscu.<br></p>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-md-6" id="main_page_card_2">
                        <div class="banner-card part-two bg-color-9edd05 radius-30 position-relative">
                            <h3>Sprawdzaj aktualności z życia firmy</h3>
                            <p class="mb-0">Bądź na bieżąco z najnowszymi wydarzeniami, informacjami i osiągnięciami naszej grupy.</p>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-md-6" id="main_page_card_3">
                        <div class="banner-card part-three bg-color-ffffff radius-30 position-relative">
                            <h3>Zasoby i narzędzia po ręką</h3>
                            <p class="mb-0">Wszystkie dokumenty masz pod ręką, koniec z przeszukiwaniem segregatorów</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="app-area overflow-hidden">
            <div class="container" style="max-width: 1520px;">
                <div class="download-area bg-color-edf1ee radius-30">
                    <div class="row g-4 align-items-center">

                        <div class="col-lg-6 col-md-12" data-cues="slideInRight" data-duration="800" data-disabled="true">
                            <div class="section-heading mb-0" id="main_page_app_content">
                                <span class="sub-title">DOŁĄCZ DO INTRANOWICZÓW</span>
                                <h2 class="fw-bold">Uzupełnij dane swojego profilu</h2>
                                <p class="mb-3">Zachęcamy do pełnego uzupełnienia informacji w swoim profilu oraz przedstawienia się, co umożliwi lepszą współpracę i integrację z resztą zespołu.</p>

                                <div class="app-btn">
                                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary me-1">Uzupełnij swój profil</a>
                                    <a href="{{ route('news') }}" class="btn btn-outline-primary me-1" style="background-color: var(--bs-btn-hover-bg); color: #fff">Sprawdź aktualności</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12" data-cues="slideInLeft" data-duration="800" data-disabled="true">
                            <div class="app-image position-relative" id="main_page_app_image">
                                <img class="radius-30" src="{{ asset('template/images/app-image-1.png') }}" alt="image">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="container" style="max-width: 1520px;">
            <div class="col-lg-12 col-md-12" data-cues="slideInRight" data-duration="800">
                <div class="section-title" style="padding-top: 80px; max-width: 1000px; margin-left: auto; margin-right: auto;" id="main_page_about_final_heading">
                    <h2 class="fw-bold text-center">Intranet to Twoje uniwersalne narzędzie – zaprojektowane z myślą o wygodzie, przejrzystości i efektywności.</h2>
                </div>
            </div>
        </div>

        <img src="{{ asset('template/images/background/zastosowania-w-przemysle-spozywczym-7bb9.png') }}" style="width: 100%;" id="main_page_background_image">

    </div>
</div>
@endsection
