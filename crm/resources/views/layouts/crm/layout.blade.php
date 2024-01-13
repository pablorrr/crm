<!DOCTYPE html>
<html lang="pl">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('template/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template/css/ui.css') }}" rel="stylesheet" type="text/css">
    <!-- calendar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

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

        <nav class="navbar navbar-inverse">
            <div class="col-md-12">
                <x-second-nav-menu className="nav navbar-nav" :menuVar="$menuVar" />
            </div>
        </nav>
    </div>
    <hr>
    <div class="col-md-12">
        @yield('content')
    </div>

</div>
<br>

<footer class="container-fluid text-center">
    <p>Footer Text</p>
</footer>
<!-- Bootstrap4 files-->
<script src="{{ asset('template/js/bootstrap.bundle.min.js') }}"
        type="text/javascript"></script>
<!-- custom javascript -->
<script src="{{ asset('template/js/script.js') }}" type="text/javascript"></script>
<!-- source:https://www.codexworld.com/select-deselect-all-checkboxes-using-jquery/-->
<!-- push testee-->
<script type="text/javascript">
    $(document).ready(function () {
        $('#select_all').on('click', function () {
            if (this.checked) {
                $('.checkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $('.checkbox').each(function () {
                    this.checked = false;
                });
            }
        });

        $('.checkbox').on('click', function () {
            if ($('.checkbox:checked').length == $('.checkbox').length) {
                $('#select_all').prop('checked', true);
            } else {
                $('#select_all').prop('checked', false);
            }
        });
    });
</script>
</body>
</html>
