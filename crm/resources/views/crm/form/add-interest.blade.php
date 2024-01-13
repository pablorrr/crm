@extends('layouts.crm.layout')

@section('title', 'Dodaj firmę - wypełnij formularz')

@section('content')

    <form action="{{--route('')--}}" method="POST">
        @csrf

        <label for="author-name">Author</label>
        <input type="text" name="author-name" class="form-control" id="author-name" value="{{--$user->name--}}">

        {{-- @if ($errors->has('author-name')) --}}
        <span class="text-danger">{{--$errors->first('author-name')--}}</span>
        {{-- @endif --}}

        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" id="title" value="{{--old('title')--}}">
        {{--  @if ($errors->has('title')) --}}

        <span class="text-danger">{{--$errors->first('title')--}}</span>
        {{--  @endif  --}}
        <label for="content">Content</label>
        <textarea name="content">{{--old('content')--}}</textarea>

        {{--    @if ($errors->has('content'))  --}}

        <span class="text-danger">{{--$errors->first('content')--}}</span>
        @endif
        <input type="submit" value="Zapisz">
    </form>
@endsection
