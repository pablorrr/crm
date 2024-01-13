<!DOCTYPE html>
<html lang="pl">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('template/css/bootstrap.css') }}" rel="stylesheet" type="text/css">

    <!-- calendar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


</head>
<body>
<style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
        margin-bottom: 0;
        border-radius: 0;
    }

    /* Add a gray background color and some padding to the footer */
    footer {
        background-color: #f2f2f2;
        padding: 25px;
    }
</style>
<div class="jumbotron">
    <div class="container text-center">
        <!-- Logo -->
        <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-md-10">


                <dl class="row">

                    <dt class="col-sm-3">Nazwa zadnia</dt>
                    <dd class="col-sm-9">{{$request->title}}</dd>

                    <dt class="col-sm-3">Opis zadania</dt>
                    <dd class="col-sm-9">{{$request->description}}</dd>

                    <dt class="col-sm-3">Start</dt>
                    <dd class="col-sm-9">{{$request->start_date}}</dd>


                    <dt class="col-sm-3">Koniec</dt>
                    <dd class="col-sm-9">{{$request->end_date}}</dd>


                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap4 files-->
<script src="{{ asset('template/js/bootstrap.bundle.min.js') }}"
        type="text/javascript"></script>
<!-- custom javascript -->
<script src="{{ asset('template/js/script.js') }}" type="text/javascript"></script>


</body>
</html>
