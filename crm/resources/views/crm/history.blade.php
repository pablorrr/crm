<x-app-layout>
    <!-- Header with "h" attribute -->
    <header class="bg-primary text-white text-center py-5">
        <h1 class="display-4">{{ __('CRM') }}</h1>
    </header>

    <!-- Main Content -->
    <div class="container mt-4">
        @if (Auth::guard('web')->check())
            <p>User is logged in</p>
            <p>Welcome, {{ Auth::guard('web')->user()->name }}</p>

        @else
            <p>User is not logged in</p>

        @endif
    </div>

    <div class="container mt-4">
        <div class="d-flex">
            <a href="{{route('persons.create')}}" class="btn btn-secondary ms-2">{{ __('Dodaj osobę') }}</a>
            <a href="{{route('companies.create')}}" class="btn btn-secondary ms-2">{{ __('Dodaj firmę') }}</a>
        </div>
    </div>
    <br>
    <hr>
    <footer class="bg-dark text-white text-center py-5">
        <div class="container">
            <p>CRM - demo</p>
        </div>
    </footer>

</x-app-layout>
