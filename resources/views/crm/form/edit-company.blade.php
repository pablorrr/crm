@extends('layouts.crm.layout')

@section('title', 'Edytuj Firmę')

@section('content')

    <!-- general edit -->
    <div class="row justify-content-center">
        <div class="col-md-2"></div>
        <div class="col-md-8">

            <form action="{{ route('companies.update', $company->id) }}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">

                <div class="form-group">
                    <label for="name">Nazwa</label>
                    <input type="text" name="name" class="form-control" id="name"
                           value="{{ $company->name }}">
                </div>

                <div class="form-group">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{$validator->errors()->first('name') }}</span>
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email"
                           value="{{ $company->email }}">
                </div>
                <div class="form-group">
                    @if ($errors->has('email'))

                        <span class="text-danger">{{$validator->errors()->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="phone">Telefon</label>
                    <input type="text" name="phone" class="form-control" id="phone"
                           value="{{ $company->phone }}">
                </div>
                <div class="form-group">
                    @if ($errors->has('phone'))
                        <span class="text-danger">{{ $validator->errors()->first('phone') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
            </form>
        </div>
        <div class="col-md-2"></div>
    </div>

@endsection
