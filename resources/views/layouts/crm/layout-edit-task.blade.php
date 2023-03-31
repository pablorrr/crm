<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
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
                <a href="{{ route('history') }}">
                    <x-jet-application-mark/>
                </a>
            </div>
            <div class="col-md-10">

                <h2>@yield('title')</h2>
            </div>
        </div>
    </div>
</div>
@if (session('status'))
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-{{ session('status')['type'] }}">
                    {{ session('status')['content'] }}
                </div>
            </div>
        </div>
    </div>
@endif

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card-header py-3">
                <p>
                    <a href="{{route('calendar.index')}}"
                       class="btn btn-success btn-sm">Kalendarz </a>
                </p>
            </div>
            @yield('content')
        </div>
    </div>
</div>

<br>

<footer class="container-fluid text-center">
    <p>Footer Text</p>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#start-date-picker').datetimepicker({format: 'YYYY-MM-DD hh:mm:ss'});
        $('#end-date-picker').datetimepicker({format: 'YYYY-MM-DD hh:mm:ss'});
    });
</script>
</body>
</html>
