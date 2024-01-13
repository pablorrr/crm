<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('template/css/bootstrap.css') }}" rel="stylesheet" type="text/css">

</head>
<body>
<div class="container">
    <div class="row">
        <div class="jumbotron">
            <div class="col-md-12">
                <div class="col-md-6">
                    <h1 class="display-4">CRM</h1>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('template/img/crm.jpg') }}" width="500pt;" class="img-fluid rounded"
                         alt="Responsive image">

                </div>
            </div>
            <hr>
            <div class="col-md-12">
                @if (Route::has('login'))

                    <div class="col-md-6">
                        @auth
                            <a href="{{ url('/history') }}">
                                <button type="button" class="btn btn-primary btn-block mb-4">Historia działań
                                </button>
                            </a>
                    </div>
                @else
                    <div class="col-md-6">
                        <a href="{{ route('login') }}">
                            <button type="button" class="btn btn-primary btn-block mb-4">Log in</button>
                        </a>
                    </div>

                    @if (Route::has('register'))
                        <div class="col-md-6">
                            <a href="{{ route('register') }}">
                                <button type="button" class="btn btn-primary btn-block mb-4">Register
                                </button>
                            </a>
                        </div>
                    @endif
                @endauth

                @endif
            </div>
        </div>
    </div>
</div>
<hr>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})

            pictures from Pixabay
        </div>
    </div>
</div>
<script src="{{ asset('template/js/jquery-2.0.0.min.js') }}"
        type="text/javascript"></script>
<!-- Bootstrap4 files-->
<script src="{{ asset('template/js/bootstrap.bundle.min.js') }}"
        type="text/javascript"></script>
<!-- custom javascript -->
<script src="{{ asset('template/js/script.js') }}" type="text/javascript"></script>
</body>
</html>
