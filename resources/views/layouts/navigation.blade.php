<style>
    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
        color: #cbcbcb;
    }
</style>
@php
    // {{-- -- showing the button when its winter -- --}} //
    $now = Carbon\Carbon::now();
    $month = $now->month;
    $day = $now->day;

    if (($month == 12 && $day >= 1) || $month == 1 || $month == 2 || ($month == 3 && $day < 20)) {
        $season = 'winter';
    } else {
        $season = 'not winter';
    }
    $isWinter = $isWinter ?? false;
@endphp
<nav x-data="{ open: false }" class="border-b" style="background-color: #3b1e54; color: #eeeeee;">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->


                <!-- Navigation Links -->
                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'trainer')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link style="color: #eeeeee;" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link style="color: #eeeeee;" href="{{ route('tables') }}" :active="request()->routeIs('tables')">
                            {{ __('Tables') }}
                        </x-nav-link>
                        <x-nav-link style="color: #eeeeee;" href="{{ route('announcements.index') }}" :active="request()->routeIs('announcements.index')">
                            {{ __('Announcement') }}
                        </x-nav-link>
                        <x-nav-link style="color: #eeeeee;" href="{{ route('spinner') }}" :active="request()->routeIs('spinner')">
                            {{ __('Spinner') }}
                        </x-nav-link>

                    </div>
                @else
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link style="color: #eeeeee;" :href="route('studentDashboard')" :active="request()->routeIs('studentDashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link style="color: #eeeeee;" href="{{ route('studentSubmissions') }}" :active="request()->routeIs('studentSubmissions')">
                            {{ __('Tasks') }}
                        </x-nav-link>
                        <x-nav-link style="color: #eeeeee;" href="{{ route('announcements') }}" :active="request()->routeIs('announcements')">
                            {{ __('Announcement') }}
                        </x-nav-link>
                        <x-nav-link style="color: #eeeeee;" href="{{ route('student-leaderBoard.index') }}" :active="request()->routeIs('student-leaderBoard.index')">
                            {{ __('Leaderboard') }}
                        </x-nav-link>
                        <x-nav-link style="color: #eeeeee;" href="{{ route('spinner') }}" :active="request()->routeIs('spinner')">
                            {{ __('Spinner') }}
                        </x-nav-link>

                    </div>
                @endif

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if ($season == 'winter')
                    <div class="switch-container"
                        style="display: flex; align-items: center; gap: 10px; margin-right: 20px;">
                        <span style="color: #eeeeee">off</span>
                        <label class="snow-switch">
                            <input type="checkbox" id="toggleSnowSwitch" {{ $isWinter ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                        <span style="color: #eeeeee">on</span>
                    </div>
                @endif
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">

        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'trainer')
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" style="color: #D4BEE4">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('tables')" :active="request()->routeIs('tables')" style="color: #D4BEE4">
                    {{ __('Tables') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('announcements.index')" :active="request()->routeIs('announcements.index')" style="color: #D4BEE4">
                    {{ __('Announcements') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('spinner')" :active="request()->routeIs('spinner')" style="color: #D4BEE4">
                    {{ __('Spinner') }}
                </x-responsive-nav-link>
            </div>
        @else
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('studentDashboard')" :active="request()->routeIs('studentDashboard')" style="color: #D4BEE4">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('studentSubmissions') }}" :active="request()->routeIs('studentSubmissions')"
                    style="color: #D4BEE4">
                    {{ __('Tasks') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('announcements') }}" :active="request()->routeIs('announcements')" style="color: #D4BEE4">
                    {{ __('Announcement') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('student-leaderBoard.index') }}" :active="request()->routeIs('student-leaderBoard.index')" style="color: #D4BEE4">
                    {{ __('Leaderboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('spinner')" :active="request()->routeIs('spinner')" style="color: #D4BEE4">
                    {{ __('Spinner') }}
                </x-responsive-nav-link>
            </div>
        @endif
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 ">
            <div class="px-4">
                <div class="font-medium text-base eeeeee ">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm eeeeee">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" style="color: #eeeeee">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" style="color: #eeeeee"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
    {{-- //---- Snow toggle ----// --}}
    <div class="snowflakes" aria-hidden="true" style="{{ $isWinter ? '' : 'display: none;' }}">
        <div class="snowflake">
            ❅
        </div>
        <div class="snowflake">
            ❅
        </div>
        <div class="snowflake">
            ❅
        </div>
        <div class="snowflake">
            ❅
        </div>
        <div class="snowflake">
            ❅
        </div>
        <div class="snowflake">
            ❅
        </div>
        <div class="snowflake">
            ❅
        </div>
        <div class="snowflake">
            ❅
        </div>
        <div class="snowflake">
            ❅
        </div>
        <div class="snowflake">
            ❆
        </div>

    </div>
    <script>
        const snowSwitch = document.getElementById('toggleSnowSwitch');
        const snowflakes = document.querySelector('.snowflakes');

        if (snowSwitch) {
            snowSwitch.addEventListener('change', () => {
                if (snowSwitch.checked) {
                    snowflakes.style.display = 'block';
                } else {
                    snowflakes.style.display = 'none';
                }
            });
        }
    </script>
</nav>
