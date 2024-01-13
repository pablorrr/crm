<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>

<!-- Modal -->
<!-- Uwaga!!! tryb dostepu nie chroniony haslem !!! zmienic!!!!! w routing middleware -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--title-->
            <div class="modal-header">
                <h5 class="modal-title">Nazwa Zadania</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="title">
                <span id="titleError" class="text-danger"></span>
            </div>
            <!-- description-->
            <div class="modal-header">
                <h5 class="modal-title">Opis Zadania</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="description">
                <span id="descriptionError" class="text-danger"></span>
            </div>


            <!-- test-->
            <div class="modal-header">
                <h5 class="modal-title">test</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="test">
                <span id="testError" class="text-danger"></span>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                <button type="button" id="saveBtn" class="btn btn-primary">Zachowaj zmiany</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="jumbotron">
        <div class="container text-center">
            <!-- Logo -->
            <div class="row">
                <div class="col-md-2 mt-5 mb-5">
                    <a href="{{ route('history') }}">
                        <x-jet-application-mark/>
                    </a>
                </div>
                <div class="col-md-10 mt-5 mb-5">
                    <h2>Kalendarz</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-4">
            <div class="card-header py-3">
                <p>
                    <a href="{{route('calendar.tasks-table')}}"
                       class="btn btn-success btn-sm">Tabela Zadań </a>
                </p>
            </div>
        </div>

        <div class="col-12">
            <h3 class="text-center mt-5"></h3>
            <div class="col-md-11 offset-1 mt-5 mb-5">

                <div id="calendar">

                </div>

            </div>
        </div>
    </div>
</div>
<!-- source calendar https://www.youtube.com/watch?v=AA0qQ_eBPR8-->
{!! $calendar->renderJsLib() !!}
{!! $calendar->renderJs() !!}
</body>
</html>
