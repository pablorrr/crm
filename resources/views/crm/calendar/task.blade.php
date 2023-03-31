@extends('layouts.crm.layout')

@section('title', 'Zadanie')

@section('content')

    <div class="container">
        <!--todo: dodoac kolumne description-->
        <div class="row">
            <div class="card-header py-3">
                <p>
                    <a href="{{route('calendar.tasks-table')}}"
                       class="btn btn-success btn-sm">Tabela Zadań </a>
                </p>
            </div>
            <div class="col md-10 offset-1 mt-5">
                <div class="card shadow mb-4">

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">title</th>
                                <th scope="col">opis</th>
                                <th scope="col">start</th>
                                <th scope="col">end</th>
                                <th scope="col">edytuj</th>
                                <th scope="col">odpowiedzialni</th>
                                <th scope="col">usuń</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">{{$task->id}}</th>
                                <td>{{$task->title}}</td>
                                <td>{{$task->description}}</td>
                                <td>{{$task->start_date}}</td>
                                <td>{{$task->end_date}}</td>
                                <td>
                                    <a href="{{ route('calendar.edit', $task->id) }}"
                                       class="btn btn-info btn-sm">Edytuj</a>
                                </td>

                                <td>
                                    @if(is_null($task->user_id))

                                        <a href="{{ route('calendar.edit', $task->id) }}"
                                           class="btn btn-info btn-sm">Przydziel</a>

                                    @else
                                        {{$task->user->name}}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('calendar.destroy', $task->id) }}"
                                       class="btn btn-danger btn-sm">Usuń</a>
                                </td>
                            </tr>


                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
