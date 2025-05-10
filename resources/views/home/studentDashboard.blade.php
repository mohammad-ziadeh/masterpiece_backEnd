@php
    $breadcrumbs = \App\Helpers\StudentBreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
    $isWinter = $isWinter ?? false;
@endphp
<x-app-layout>

    <x-slot name="header">
        @if ($season == 'winter')
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                <h2 class="font-semibold text-xl" style="color: #3b1e54; margin-bottom: 20px;">
                    {{ __('Dashboard') }}
                </h2>
                <div class="switch-container" style="display: flex; align-items: center; gap: 10px;">
                    <span>off</span>
                    <label class="snow-switch">
                        <input type="checkbox" id="toggleSnowSwitch" {{ $isWinter ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                    <span>on</span>
                </div>
            </div>
        @else
            <h2 class="font-semibold text-xl" style="color: #3b1e54; margin-bottom: 20px;">
                {{ __('Dashboard') }}
            </h2>
        @endif

        <ul class="breadcrumbs">
            @foreach ($breadcrumbs as $breadcrumb)
                <li>
                    <a style="color: #3b1e54;" href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                </li>
            @endforeach
        </ul>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">


                <section class="section9">

                    <div class="sb">
                        <h2 style="font-weight:bold; font-size: x-large; text-align: center; color: #3b1e54;">Student
                            Information</h2>
                        <h3 style="font-size: x-large; text-align: center; margin-top: 20px; ">
                            {{ Auth::user()->name }}</h3>
                        <div style="display: flex; justify-content: space-between;">
                            <h3 style=" font-size: large; margin-top: 30px;">ID:</h3>
                            <h3 style=" font-size: large; margin-top: 30px; font-weight: bold;">{{ Auth::user()->id }}
                            </h3>
                        </div>

                        <div class="hr-container">
                            <span>★★★</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <h3 style=" font-size: large;">Email: </h3>
                            <h3 style=" font-size: large; font-weight: bold;">{{ Auth::user()->email }}</h3>
                        </div>
                        <div class="hr-container">
                            <span>★★★</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <h3 style=" font-size: large;">Phone:</h3>
                            <h3 style=" font-size: large;">0791318735</h3>
                        </div>
                        <div class="hr-container">
                            <span>★★★</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <h3 style="font-size: large;">Joining Date:</h3>
                            <h3 style="font-size: large; font-weight: bold;">
                                {{ Auth::user()->created_at->format('d F Y') }}</h3>
                        </div>

                    </div>
                    <div class="sd">
                        <h2
                            style="font-weight:bold; font-size: x-large; text-align: center; margin-bottom: 40px; color: #3b1e54;">
                            Student Attendance:</h2>
                        <div style="display: flex; justify-content: space-between;">
                            <h3 style=" font-size: large;">Justified Absence:</h3>
                            <h3 style=" font-size: large;">{{ $userJustifyAbsent }}</h3>
                        </div>
                        <div class="hr-container">
                            <span>★★★</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <h3 style=" font-size: large;">Non-Justified Absence::</h3>
                            <h3 style=" font-size: large;">{{ $userAbsent }}</h3>
                        </div>
                        <div class="hr-container">
                            <span>★★★</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <h3 style=" font-size: large;">Tardy:</h3>
                            <h3 style=" font-size: large;">{{ $userLate }}</h3>
                        </div>

                    </div>
                    <div class="hd">
                        @if ($time > '06:00:00' && $time < '18:00:00')
                            <div class="background-day">
                                <div class="sun"></div>
                                <div id="clock">Loading...</div>
                            </div>
                        @else
                            <div class="background-night">
                                <div class="moon"></div>
                                <div class="shooting-stars sh-star1">
                                </div>
                                <div class="shooting-stars sh-star2">
                                </div>
                                <div class="shooting-stars sh-star3">
                                </div>

                                <div id="clock">Loading...</div>
                            </div>
                        @endif
                    </div>
                    <div class="ft weather-wrapper" id="weatherBox" style="background-color: #3b1e54">
                      {{-- <div id="temperature" class="temperature-text">Loading temperature...</div> --}}

                        <div class="weather-card" >
                            <div class="weather-icon" id="weatherIcon"></div>
                            <h1 id="tempValue"></h1>
                            <p id="cityName"></p>
                        </div>
                    </div>


                    <div class="mb">
                        <h2 style="font-weight:bold; font-size: x-large; text-align: center; color: #3b1e54;">
                            Undone Tasks
                        </h2>

                        @if ($undoneTasks->isEmpty())
                            <p style="text-align: center; margin-top: 10px;">You have completed all your assigned tasks.
                            </p>
                        @else
                            <ul style="list-style: none; padding-left: 0;">
                                @foreach ($undoneTasks as $task)
                                    <li
                                        style="margin: 10px 0; padding: 10px; border: 1px solid #ccc; border-radius: 8px; display: flex; justify-content: space-between;">
                                        <strong>{{ $task->name }} (ID:{{ $task->id }})</strong>
                                        @if ($task->due_date > $now)
                                            <div style="color: gray; font-weight: bold;">Due by:
                                                {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }} at
                                                {{ \Carbon\Carbon::parse($task->due_date)->format('h:i A') }}</div>
                                        @else
                                            <div style="color: red; font-weight: bold;">Overdue:
                                                {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }} at
                                                {{ \Carbon\Carbon::parse($task->due_date)->format('h:i A') }}</div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                </section>

            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 40px">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">


            </div>

        </div>
    </div>

    <style>
        .sun {
            background: #ffcd41;
            border-radius: 50%;
            box-shadow: rgba(255, 255, 0, 0.1) 0 0 0 4px;
            animation: light 800ms ease-in-out infinite alternate,
                weather-icon-move 5s ease-in-out infinite;
            width: 60px;
            height: 60px;
        }

        .weather-icon {
            position: relative;
            width: 50px;
            height: 50px;
            top: 0;

            float: right;
            margin: 40px 40px 0 0;
            animation: weather-icon-move 5s ease-in-out infinite;
            will-change: transform;
        }

        .cloud {
            margin-right: 60px;
            background: #bad0de;
            border-radius: 20px;
            width: 25px;
            height: 25px;
            box-shadow: #bad0de 24px -6px 0 2px, #bad0de 10px 5px 0 5px,
                #bad0de 30px 5px 0 2px, #bad0de 11px -8px 0 -3px,
                #bad0de 25px 11px 0 -1px;
            position: relative;
        }
    </style>

    <style>
        .section9 {
            display: grid;
            gap: 15px;
            padding: 15px;
            grid-template-columns: repeat(10, 1fr);
            grid-template-rows: repeat(12, 1fr);
            grid-template-areas:
                "sb sb sb sb ft ft ft hd hd hd"
                "sb sb sb sb ft ft ft hd hd hd"
                "sb sb sb sb ft ft ft hd hd hd"
                "sb sb sb sb ft ft ft hd hd hd"
                "sb sb sb sb mb mb mb mb mb mb"
                "sb sb sb sb mb mb mb mb mb mb"
                "sb sb sb sb mb mb mb mb mb mb"
                "sd sd sd sd mb mb mb mb mb mb"
                "sd sd sd sd mb mb mb mb mb mb"
                "sd sd sd sd mb mb mb mb mb mb"
                "sd sd sd sd mb mb mb mb mb mb"
                "sd sd sd sd mb mb mb mb mb mb";
        }

        .sb,
        .sd,
        .ft,
        .mb {
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
        }

        .hd {
            border-radius: 5px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
        }

        .sb {
            grid-area: sb;
        }

        .sd {
            grid-area: sd;
        }

        .hd {
            grid-area: hd;
        }

        .ft {
            grid-area: ft;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;

        }

        .mb {
            grid-area: mb;
        }

        .hr-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
        }

        .hr-container::before,
        .hr-container::after {
            content: "";
            flex: 1;
            border-bottom: 2px solid #ccc;
            margin: 0 10px;
        }

        .hr-container span {
            font-size: 18px;
            color: #3b1e54;
        }

        @media (max-width: 1024px) {
            .section9 {
                grid-template-columns: 1fr;
                grid-template-rows: auto;
                grid-template-areas:
                    "sb"
                    "ft"
                    "hd"
                    "sd"
                    "mb";
            }
        }

        @media (max-width: 640px) {
            .switch-container {
                flex-direction: column;
                gap: 5px;
            }

            .section9 {
                display: grid;
                gap: 15px;
                padding: 15px;
                grid-template-columns: repeat(5, 1fr);
                grid-template-rows: repeat(20, 1fr);
                grid-template-areas:
                    "hd hd hd hd hd"
                    "hd hd hd hd hd"
                    "ft ft ft ft ft"
                    "ft ft ft ft ft"
                    "sb sb sb sb sb"
                    "sb sb sb sb sb"
                    "sb sb sb sb sb"
                    "sb sb sb sb sb"
                    "sb sb sb sb sb"
                    "sb sb sb sb sb"
                    "sb sb sb sb sb"
                    "sd sd sd sd sd"
                    "sd sd sd sd sd"
                    "sd sd sd sd sd"
                    "sd sd sd sd sd"
                    "sd sd sd sd sd"
                    "mb mb mb mb mb"
                    "mb mb mb mb mb"
                    "mb mb mb mb mb"
                    "mb mb mb mb mb";
            }

            .sb,
            .sd,
            .ft,
            .mb,
            .hd {
                font-size: medium
            }

            .sb,
            .sd,
            .hd,
            .ft,
            .mb {
                padding: 8px;
            }

        }
    </style>


    <script>
    const apiKey = '24478300f38ab762c47cdfac8dd52290';
    const city = "{{ Auth::user()->city ?? 'Madrid' }}";

    document.addEventListener('DOMContentLoaded', () => {
        fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${apiKey}`)
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error ${response.status}`);
                return response.json();
            })
            .then(data => {
                const temp = Math.round(data.main.temp);
                const weather = data.weather[0].main.toLowerCase();

                // Update DOM
                const temperatureEl = document.getElementById('temperature');
                const tempValEl = document.getElementById('tempValue');
                const cityNameEl = document.getElementById('cityName');
                const icon = document.getElementById('weatherIcon');
                const weatherBox = document.getElementById('weatherBox');

                if (temperatureEl) temperatureEl.textContent = `${temp}°C in ${city}`;
                if (tempValEl) tempValEl.textContent = `${temp}º`;
                if (cityNameEl) cityNameEl.textContent = city;

                // Reset weather classes
                if (weatherBox) weatherBox.classList.remove('sunny', 'rainy');
                if (icon) icon.className = 'weather-icon'; // clear previous

                // Add new weather styles
                if (weather.includes('rain') || weather.includes('drizzle') || weather.includes('thunderstorm')) {
                    weatherBox?.classList.add('rainy');
                    icon?.classList.add('cloud');
                } else {
                    weatherBox?.classList.add('sunny');
                    icon?.classList.add('sun');
                }
            })
            .catch(error => {
                console.error('Weather fetch error:', error);
                const tempEl = document.getElementById('temperature');
                if (tempEl) tempEl.textContent = 'Weather unavailable';
            });
    });
</script>


    <script>
        function updateClock() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');

            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>


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

</x-app-layout>
