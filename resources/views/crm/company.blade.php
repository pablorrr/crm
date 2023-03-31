@extends('layouts.crm.layout')

@section('title', 'Firmy')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="card shadow mb-4">
            <div class="card-body">

                @if(count($companies )>0)
                    <form action="/delete-companies" method="post">
                        @csrf
                        <table class="table table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Nazwa firmy</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telefon</th>
                                <th scope="col">Edytuj</th>
                                <th scope="col">
                                    <input type="checkbox" id="select_all"/>
                                </th>
                                <th scope="col">
                                    <input type="submit" class="btn btn-danger btn-sm" value="Usuń wybraną Firmę">
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($companies as $company)
                                <tr>
                                    <th scope="row">{{$company->id}}</th>
                                    <td>{{$company->name}}</td>
                                    <td>{{$company->email}}</td>
                                    <td>{{$company->phone}}</td>

                                    <td>
                                        <a href="{{route('companies.edit',$company->id)}}"
                                           class="btn btn-info btn-sm">Edit</a>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="checkbox" name="ids[{{$company->id}}]"
                                               value="{{$company->id}}">

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </form>
                @else

                    <h3> Brak Firm w Bazie Danych</h3>

                @endif
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

@endsection
