<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded  border-gray-300  text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 "
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 ">{{ __('Remember me') }}</span>
            </label>
        </div>
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600  hover:text-gray-900  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 "
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        <div class="flex items-center justify-end mt-4">



                {{-- <x-primary-button class="ms-4">
                    {{ __('Log in') }}
                </x-primary-button> --}}
                <button class="loginButton " type="submit" >
                    Login
                    <div class="star-1">
                        <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1"
                            style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                            viewBox="0 0 784.11 815.53" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <defs></defs>
                            <g id="Layer_x0020_1">
                                <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                                <path class="fil0"
                                    d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z">
                                </path>
                            </g>
                        </svg>
                    </div>
                    <div class="star-2">
                        <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1"
                            style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                            viewBox="0 0 784.11 815.53" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <defs></defs>
                            <g id="Layer_x0020_1">
                                <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                                <path class="fil0"
                                    d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z">
                                </path>
                            </g>
                        </svg>
                    </div>
                    <div class="star-3">
                        <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1"
                            style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                            viewBox="0 0 784.11 815.53" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <defs></defs>
                            <g id="Layer_x0020_1">
                                <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                                <path class="fil0"
                                    d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z">
                                </path>
                            </g>
                        </svg>
                    </div>
                    <div class="star-4">
                        <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1"
                            style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                            viewBox="0 0 784.11 815.53" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <defs></defs>
                            <g id="Layer_x0020_1">
                                <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                                <path class="fil0"
                                    d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z">
                                </path>
                            </g>
                        </svg>
                    </div>
                    <div class="star-5">
                        <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1"
                            style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                            viewBox="0 0 784.11 815.53" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <defs></defs>
                            <g id="Layer_x0020_1">
                                <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                                <path class="fil0"
                                    d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z">
                                </path>
                            </g>
                        </svg>
                    </div>
                    <div class="star-6">
                        <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1"
                            style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                            viewBox="0 0 784.11 815.53" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <defs></defs>
                            <g id="Layer_x0020_1">
                                <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                                <path class="fil0"
                                    d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z">
                                </path>
                            </g>
                        </svg>
                    </div>
                </button>

        </div>
    </form>
</x-guest-layout>
