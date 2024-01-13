<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <x-jet-nav-link class="nav-link" href="{{ route('history') }}" :active="request()->routeIs('history')">
                    {{ __('Historia działań') }}
                </x-jet-nav-link>
            </li>
            <li class="nav-item">
                <x-jet-nav-link class="nav-link" href="{{ route('persons.index') }}"
                                :active="request()->routeIs('persons.index')">
                    {{ __('Osoby') }}
                </x-jet-nav-link>
            </li>
            <li class="nav-item">
                <x-jet-nav-link class="nav-link" href="{{ route('companies.index') }}"
                                :active="request()->routeIs('companies.index')">
                    {{ __('Firmy') }}
                </x-jet-nav-link>

            </li>
            <li class="nav-item">
                <x-jet-nav-link class="nav-link" href="{{ route('calendar.index') }}"
                                :active="request()->routeIs('calendar.index')">
                    {{ __('Kalendarz') }}
                </x-jet-nav-link>
            </li>
            <li class="nav-item">
                <x-jet-nav-link class="nav-link" href="{{ route('chart.chart') }}"
                                :active="request()->routeIs('chart.chart')">
                    {{ __('Wykres') }}
                </x-jet-nav-link>
            </li>
            <li class="nav-item">
                <x-jet-nav-link class="nav-link" href="{{ route('chat') }}" :active="request()->routeIs('chat')">
                    {{ __('Czat') }}
                </x-jet-nav-link>
            </li>
        </ul>
        @if (Auth::guard('web')->check())
        <ul class="nav navbar-nav navbar-right">
            <li>
                <form class="nav-link" method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button type="submit" class="btn btn-primary">   {{ __('Log Out') }}</button>
                </form>
            </li>
        </ul>
        @endif
    </div>
</nav>




