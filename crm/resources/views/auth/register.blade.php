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
        <div class="container mt-5">
            <h2>{{ __('Register') }}</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <x-jet-label for="name" value="{{ __('Name') }}"/>
                    <x-jet-input id="name" class="form-control" type="text" name="name" :value="old('name')"
                                 required autofocus autocomplete="name"/>
                </div>

                <div class="mb-3">
                    <x-jet-label for="email" value="{{ __('Email') }}"/>
                    <x-jet-input id="email" class="form-control" type="email" name="email" :value="old('email')"
                                 required/>
                </div>

                <div class="mb-3">
                    <x-jet-label for="password" value="{{ __('Password') }}"/>
                    <x-jet-input id="password" class="form-control" type="password" name="password" required
                                 autocomplete="new-password"/>
                </div>

                <div class="mb-3">
                    <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}"/>
                    <x-jet-input id="password_confirmation" class="form-control" type="password"
                                 name="password_confirmation" required autocomplete="new-password"/>
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mb-3">
                        <x-jet-label for="terms">
                            <div class="flex items-center">
                                <x-jet-checkbox name="terms" id="terms"/>

                                <div class="ml-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-jet-label>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-jet-button class="btn btn-primary">
                        {{ __('Register') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
