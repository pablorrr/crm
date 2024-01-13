@extends('layouts.crm.layout')

@section('title', 'Dodaj osobę')

@section('content')

    <!-- general edit -->
    <div class="row justify-content-center">
        <div class="col-md-2"></div>
        <div class="col-md-8">

            <form action="{{route('persons.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Imię</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{$validator->errors()->first('name') }}</span>
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="surname">Nazwisko</label>
                    <input type="text" name="surname" class="form-control" id="name" value="{{ old('surname') }}">
                </div>
                <div class="form-group">
                    @if ($errors->has('surname'))
                        <span class="text-danger">{{$validator->errors()->first('surname') }}</span>
                        <span class="text-danger">{{ $errors->first('surname') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    @if ($errors->has('email'))

                        <span class="text-danger">{{$validator->errors()->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="phone">Telefon</label>
                    <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone') }}">
                </div>
                <div class="form-group">
                    @if ($errors->has('phone'))
                        <span class="text-danger">{{ $validator->errors()->first('phone') }}</span>
                    @endif
                </div>


                <label for="photo">Foto</label>
                <input type="file" name="photo" class="form-control" id="photo" value="{{ old('photo') }}">

                <div class="form-group">
                    @if ($errors->has('photo'))
                        <span class="text-danger">{{ $validator->errors()->first('photo') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Zapisz</button>

            </form>
        </div>
        <div class="col-md-2"></div>
    </div>
@endsection
