<!DOCTYPE html>
<html lang="pl_PL" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="icon" href="{{ asset('template/images/favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/images/favicon.png') }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">

    <link href="{{ asset('template/models/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('template/models/vendor/toastr/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/models/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('template/models/css/style.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('template/models/css/add_style.css') }}" rel="stylesheet" media="screen">

</head>

<body class="h-100">

    <div class="authincation h-100 pt-150">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">

                                    <div class="text-center mb-3">
                                        <a><img src="{{ asset('template/images/logo/clouda-white.png') }}" alt="Logo"></a>
                                    </div>
                                    <h4 class="text-center mb-4 text-white">Zaloguj się</h4>

                                    {{ $slot }}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('template/models/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('template/models/js/deznav-init.js') }}"></script>
    <script src="{{ asset('template/models/js/custom.js') }}"></script>

</body>

</html>
