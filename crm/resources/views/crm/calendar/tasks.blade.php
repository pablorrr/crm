@extends('layouts.crm.layout')

@section('title', 'Tabela Zadań')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <a href="{{route('tasks.print.pdf')}}" class="btn btn-info btn-sm">Drukuj PDF</a>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
        </div>

        @if(count($tasks )>0)
            <!-- Page Heading -->
            <form action="/delete-tasks" method="get">

                @csrf
                <table class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Nazwa</th>
                        <th scope="col">Opis</th>
                        <th scope="col">Początek</th>
                        <th scope="col">Koniec</th>
                        <th scope="col">Odpowiedzialni</th>
                        <th scope="col">Edytuj</th>
                        <th scope="col">
                            <input type="checkbox" id="select_all"/>
                        </th>
                        <th scope="col">
                            <input type="submit" class="btn btn-danger btn-sm" value="Usuń wybrane Zadania">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)

                        <tr>
                            <td>{{$task->id}}</td>
                            <td>{{$task->title}}</td>
                            <td>{{$task->description}}</td>
                            <td>{{$task->start_date}}</td>
                            <td>{{$task->end_date}}</td>
                            <td>
                                @if(is_null($task->user_id))

                                    <a href="{{ route('calendar.edit', $task->id) }}"
                                       class="btn btn-info btn-sm">Przydziel</a>
                                @else
                                    {{$task->user->name}}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('calendar.edit', $task->id) }}"
                                   class="btn btn-info btn-sm">Edytuj</a>
                            </td>
                            <td>
                                <input type="checkbox" class="checkbox" name="ids[{{$task->id}}]" value="{{$task->id}}">
                            </td>

                        </tr>
                    </thead>
                    @endforeach

                    </tbody>
                </table>
            </form>
        @else

            <h3> Brak Zadań</h3>

        @endif


    </div>
    <!-- /.container-fluid -->

@endsection
