<x-guest-layout>
    @if (Route::has('login'))
        {{-- <div class="w-full max-w-xs mx-auto mt-32">
            <h1 class="ml-[60px] text-green-700 text-7xl font-bold">S.H.O</h1>

        </div> --}}

        <div class="w-full max-w-sm mx-auto mt-40 bg-white rounded-lg shadow-lg">
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

                    <div class="w-full join join-vertical">
                        <div class="w-full h-8 bg-green-600 join-item">
                            <p class="mt-1 text-lg font-semibold text-white ml-14 ">SENIOR HOUSE OFFICER REPORT</p>
                        </div>
                        <div class="join-item"></div>
                    </div>
                    <div class="p-4">
                        <div>
                            <x-label for="email" value="{{ __('Employee ID') }}" />
                            <x-input id="email"
                                class="block w-full mt-1 border-green-700 focus:border-green-700 focus:ring-green-700"
                                type="text" name="emp_id" :value="old('emp_id')" required autofocus
                                autocomplete="username" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password" value="{{ __('Password') }}" />
                            <x-input id="password"
                                class="block w-full mt-1 border-green-700 focus:border-green-700 focus:ring-green-700 "
                                type="password" name="password" required autocomplete="current-password" />
                        </div>

                        <div class="block mt-4">
                            <label for="remember_me" class="flex items-center">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            {{-- @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="ml-4 text-green-700 font-base hover:text-blue-700 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                            @endif --}}
                            {{-- @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                            @endif --}}

                            <x-button class="ml-4 text-white bg-green-700 hover:bg-gray-700 ">
                                {{ __('Log in') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            @endauth
        </div>
    @endif
</x-guest-layout>
