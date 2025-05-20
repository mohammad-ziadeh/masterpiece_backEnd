@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl " style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Leaderboard') }}
        </h2>
        <div style="display: flex; justify-content: space-between;">
            <ul class="breadcrumbs">
                @foreach ($breadcrumbs as $breadcrumb)
                    <li>
                        <a style="color: #3b1e54;" href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                    </li>
                @endforeach
            </ul>
            <button class="btn btn-success" onclick="startTour()">Start Tour</button>
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
        <div class="p-4 sm:p-8 bg-white" style="margin-top: 20px; ">
            <div class="row">
                <div class="col grid-margin stretch-card">
                    <div class="card"
                        data-intro="This is the leaderboard here u can see the students who have the highest points that they have earned"
                        data-step="1">
                        <div class="card-body">
                            <div class="body">
                                <div class="main">
                                    <a href="{{ route('leaderboard.lastWeek') }}" class="btn btn-warning"
                                        data-intro="By clicking here u can see the last week leaderboard"
                                        data-step="2">
                                        Last Week Leaderboard
                                    </a>
                                    <div style="text-align: center; margin-top: 20px;">

                                    </div>
                                    <h1 style="text-align: center; font-size: xx-large; font-family: 'Rubik', sans-serif;  color: #141a39;"
                                        data-intro="This is the countdown timer that shows the time left till the leaderboard resets"
                                        data-step="3" id="weeklyCountdown"></h1>
                                    <div id="header">
                                        <h1 class="h1">Ranking</h1>
                                        <img class="gold-medal" src="{{ asset('images/allBadges.png') }}"
                                            alt="gold medal" />
                                    </div>
                                    <div id="leaderboard"
                                        data-intro="This is the leaderboard that shows the top 5 students with the highest points"
                                        data-step="4">
                                        <div class="ribbon"></div>
                                        <table class="table">
                                            @foreach ($topUsers as $index => $user)
                                                <tr class="tr">
                                                    <td class="td number">{{ $index + 1 }}</td>
                                                    <td class="td name" style="display: flex; align-items: center;">
                                                        @if (!empty($user->avatar) && file_exists(public_path('storage/' . $user->avatar)))
                                                            <img src="{{ asset('storage/' . $user->avatar) }}"
                                                                alt="{{ $user->name }}"
                                                                style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-right: 20px;">
                                                        @else
                                                            <img src="{{ asset('images/' . ($user->gender === 'female' ? 'femalAvatar.png' : 'maleAvatar.png')) }}"
                                                                alt="Default Avatar"
                                                                style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-right: 20px;">
                                                        @endif{{ $user->name }}
                                                    </td>
                                                    <td class="td points">
                                                        {{ $user->weekly_points }}
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </table>
                                    </div>
                                </div>
                                <div style="text-align: center; margin-top: 20px;">
                                    <a href="{{ route('leaderboard.full') }}" class="btn btn-primary"
                                        data-intro="By clicking here u can see the full leaderboard for this week"
                                        data-step="5">
                                        View Full Leaderboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script>
        function updateWeeklyCountdown() {
            const now = new Date();
            const endOfWeek = new Date();
            const day = endOfWeek.getDay();
            const distanceToSunday = 7 - day;
            endOfWeek.setDate(endOfWeek.getDate() + distanceToSunday);
            endOfWeek.setHours(23, 59, 59, 999);

            const diff = endOfWeek - now;
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((diff / 1000 / 60) % 60);
            const seconds = Math.floor((diff / 1000) % 60);

            document.getElementById("weeklyCountdown").innerText =
                `Time left till reset: ${days}d ${hours}h ${minutes}m ${seconds}s`;
        }

        setInterval(updateWeeklyCountdown, 1000);
    </script>
    <script>
        function startTour() {
            introJs().start();
        }
    </script>
</x-app-layout>
