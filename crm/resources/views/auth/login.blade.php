<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <br>

            <div class="jumbotron">
                <div class="container text-center">
                    <!-- Logo -->
                    <div class="row">
                        <div class="col-md-2">
                            <a href="{{ route('main') }}">
                                <x-jet-application-mark/>
                            </a>
                        </div>
                        <div class="col-md-10">
                            <h1>{{ __('CRM') }}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </x-slot>

        <x-jet-validation-errors class="mb-4"/>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        <div class="container mt-5">
            <h2>{{ __('Log in') }}</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <x-jet-label for="name" value="{{ __('Name') }}"/>
                    <x-jet-input id="name" class="form-control" type="name" name="name" :value="old('name')"
                                 required autofocus/>
                </div>

                <div class="mb-3">
                    <x-jet-label for="password" value="{{ __('Password') }}"/>
                    <x-jet-input id="password" class="form-control" type="password" name="password" required
                                 autocomplete="current-password"/>
                </div>

                <div class="mb-3">
                    <label for="remember_me" class="flex items-center">
                        <x-jet-checkbox id="remember_me" name="remember"/>
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900"
                           href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-jet-button class="btn btn-primary">
                        {{ __('Log in') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
