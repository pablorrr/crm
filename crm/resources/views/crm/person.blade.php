@extends('layouts.crm.layout')

@section('title', 'Osoby')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="card shadow mb-4">
            <div class="card-body">
                @if(count($persons )>0)
                    <form action="/delete-persons" method="post">
                        @csrf
                        <table class="table table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Zdjęcie</th>
                                <th scope="col">Imię</th>
                                <th scope="col">Nazwisko</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telefon</th>
                                <th scope="col">Edytuj</th>
                                <th scope="col">
                                    <input type="checkbox" id="select_all"/>
                                </th>
                                <th scope="col">
                                    <input type="submit" class="btn btn-danger btn-sm" value="Usuń wybraną Osobę">
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($persons as $person)
                                <tr>
                                    <th scope="row">{{$person->id}}</th>
                                    @if($person->photo)
                                        <td><img src="{{url('/photo/'.$person->photo)}}" alt="" width="50px"
                                                 height="50px"/></td>
                                        @else
                                        <td><img src="{{url('/photo/default.jpg')}}" alt="" width="50px"
                                                 height="50px"/></td>
                                    @endif
                                    <td>{{$person->name}}</td>
                                    <td>{{$person->surname}}</td>
                                    <td>{{$person->email}}</td>
                                    <td>{{$person->phone}}</td>
                                    <td>
                                        <a href="{{ route('persons.edit', $person->id) }}"
                                           class="btn btn-info btn-sm">Edytuj</a>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="checkbox" name="ids[{{$person->id}}]"
                                               value="{{$person->id}}">
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </form>
                @else

                    <h3> Brak Osób odpowiedzialnych</h3>

                @endif


            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

@endsection
