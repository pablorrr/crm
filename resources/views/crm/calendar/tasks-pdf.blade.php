@extends('layouts.crm.layout-pdf')

@section('title', 'Tabela Zadan')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <h1>Tabela zadan</h1>
        <!-- Page Heading -->
        @if(count($tasks )>0)
            <table border="1">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Nazwa</th>
                    <th scope="col">Opis</th>
                    <th scope="col">Poczatek</th>
                    <th scope="col">Koniec</th>
                    <th scope="col">Odpowiedzialni</th>
                </tr>
                @foreach($tasks as $task)

                    <tr>
                        <td>{{$task->id}}</td>
                        <td>{{$task->title}}</td>
                        <td>{{$task->description}}</td>
                        <td>{{$task->start_date}}</td>
                        <td>{{$task->end_date}}</td>
                        @if(is_null($task->user_id))
                            <td>Nie przydzielono</td>
                        @else
                            <td>{{$task->user->name}}</td>
                        @endif

                    </tr>

                @endforeach
            </table>
        @else
            <h3> Brak Zadan</h3>
        @endif
    </div>
    <!-- /.container-fluid -->
@endsection
