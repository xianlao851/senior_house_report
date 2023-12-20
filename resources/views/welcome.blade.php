<x-guest-layout>
    <x-authentication-card>
        {{-- <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot> --}}
        @if (Route::has('login'))
            <div class="">
                @auth
                    <div class=""><a href="{{ url('/dashboard') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    </div>
                @else
                    {{-- <a href="{{ route('login') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                        in</a> --}}
                    <x-validation-errors class="mb-4" />

                    @if (session('status'))
                        <div class="mb-4 text-sm font-medium text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div>
                            <x-label for="email" value="{{ __('Employee ID') }}" />
                            <x-input id="email" class="block w-full mt-1" type="text" name="emp_id"
                                :value="old('emp_id')" required autofocus autocomplete="username" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password" value="{{ __('Password') }}" />
                            <x-input id="password" class="block w-full mt-1" type="password" name="password" required
                                autocomplete="current-password" />
                        </div>

                        <div class="block mt-4">
                            <label for="remember_me" class="flex items-center">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="ml-4 text-gray-600 font-base hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                            @endif
                            {{-- @if (Route::has('password.request'))
                            <a class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif --}}

                            <x-button class="ml-4">
                                {{ __('Log in') }}
                            </x-button>
                        </div>
                    </form>


                @endauth
            </div>
        @endif
    </x-authentication-card>
</x-guest-layout>
