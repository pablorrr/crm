<!DOCTYPE html>
<html lang="pl">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            @yield('content')
        </div>

    </div>
</div>

<hr>
</body>
</html>
