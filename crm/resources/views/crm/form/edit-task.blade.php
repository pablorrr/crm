@extends('layouts.crm.layout-edit-task')

@section('title', 'Edytuj zadanie')

@section('content')

    <!-- general edit -->
    <div class="row justify-content-center">
        <div class="col-md-2"></div>
        <div class="col-md-8">

            <form action="{{ route('calendar.update', $task->id) }}" method="POST" class="col-lg-6 offset-lg-3">
                @csrf
                <input type="hidden" name="_method" value="PUT">

                <div class="form-group">
                    <label for="title">Tytuł</label>
                    <input type="text" name="title" class="form-control" id="title"
                           value="{{ $task->title }}">
                    @if ($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="description">Opis</label>
                    <input type="text" name="description" class="form-control" id="description"
                           value="{{ $task->description }}">

                    @if ($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif

                </div>

                <div class="form-group">
                    <label for="start_date">Start</label>
                    <div class="input-group date" id="start-date-picker">
                        <input type="text" name="start_date" id="start_date"
                               class="form-control" value="{{ $task->start_date }}">
                        <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                    </div>
                    @if ($errors->has('start_date'))
                        <span class="text-danger">{{ $errors->first('start_date') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="end_date">Koniec</label>
                    <div class="input-group date" id="end-date-picker">
                        <input type="text" name="end_date" id="end_date" class="form-control"
                               value="{{ $task->end_date }}">
                        <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                    </div>
                </div>
                @if ($errors->has('end_date'))
                    <span class="text-danger">{{ $errors->first('end_date') }}</span>
                @endif

                <div class="form-group">
                    <label for="user_id"> Wybierz osobę odpowiedzialną</label>
                    <select name="user_id" id="user_id" class="form-control">

                        @if(!is_null($task->user_id))
                            <option value="{{ $task->user->id }}"
                                    selected>{{ $task->user->name }}</option>
                        @endif

                        @foreach($users as $user)
                            @if(($task->user_id) !==($user->id))
                                <option value="{{  $user->id }}">{{  $user->name }}</option>
                            @endif
                        @endforeach

                    </select>

                    @if ($errors->has('user_id'))
                        <span class="text-danger">{{ $errors->first('user_id') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
            </form>
        </div>
        <div class="col-md-2"></div>
    </div>
@endsection
