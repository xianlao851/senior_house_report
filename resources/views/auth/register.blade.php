<x-guest-layout>
    <div class="w-full max-w-sm mx-auto mt-40 bg-white rounded-lg shadow-lg">
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="w-full join join-vertical">
                <div class="w-full h-6 bg-green-600 join-item"></div>
                <div class="join-item"></div>
            </div>
            <div class="p-4">
                <div>
                    <x-label for="name" value="{{ __('Employee ID') }}" />
                    <x-input id="emp_id"
                        class="block w-full mt-1 border-green-700 focus:border-green-700 focus:ring-green-700"
                        type="text" name="emp_id" :value="old('emp_id')" required autofocus autocomplete="emp_id" />
                </div>

                {{-- <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                </div> --}}

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password"
                        class="block w-full mt-1 border-green-700 focus:border-green-700 focus:ring-green-700"
                        type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation"
                        class="block w-full mt-1 border-green-700 focus:border-green-700 focus:ring-green-700"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms" required />

                                <div class="ml-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' =>
                                            '<a target="_blank" href="' .
                                            route('terms.show') .
                                            '" class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                            __('Terms of Service') .
                                            '</a>',
                                        'privacy_policy' =>
                                            '<a target="_blank" href="' .
                                            route('policy.show') .
                                            '" class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                            __('Privacy Policy') .
                                            '</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-label>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <a class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-button class="ml-4 text-white bg-green-700">
                        {{ __('Register') }}
                    </x-button>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
