@extends('layouts.crm.layout')

@section('title', 'interesy')

@section('content')


    <div class="container">

        <x-jet-nav-link href="{{ route('history') }}" :active="request()->routeIs('history')">
            {{ __('Historia działań') }}
        </x-jet-nav-link>
    </div>
@endsection
