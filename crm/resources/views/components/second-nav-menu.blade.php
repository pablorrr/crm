<ul class="{{$className}}">

    @if(!Request::is('calendar/index'))
        <li>
            <a href="{{route('calendar.index')}}" >{{$menuVar[0]}}</a>
        </li>
    @endif
    @if(!Request::is('persons/create'))
        <li>
            <a href="{{route('persons.create')}}">{{$menuVar[1]}}</a>
        </li>
    @endif

    @if(!Request::is('companies/create'))
        <li>
            <a href="{{route('companies.create')}}">{{$menuVar[2]}}</a>
        </li>
    @endif


</ul>
