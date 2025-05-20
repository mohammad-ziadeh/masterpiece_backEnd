@php
    $breadcrumbs = \App\Helpers\StudentBreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
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
            <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;"
                data-intro="Here you will see all the existing badges with there Image, Title and Description."
                data-step="2">
                @foreach ($badges as $badge)
                    <div class="badgeCard">
                        <img class="badgeImg" src="{{ asset('storage/' . $badge->image_url) }}"
                            alt="{{ $badge->title }}" width="90">
                        <strong>{{ $badge->title }}</strong>
                        <p style="padding: 10px; text-align: center;">{{ $badge->description ?? '—' }}</p>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col grid-margin stretch-card">
                    <div class="card"
                        data-intro="This is the leaderboard here u can see the students who have the highest points that they have earned"
                        data-step="1">
                        <div class="card-body">
                            <div class="body">
                                <div class="main">
                                    <a href="{{ route('studentLeaderboard.lastWeek') }}" class="btn btn-warning"
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
                                                    <td class="td number">
                                                        <a
                                                            href="{{ route('student-leaderboard.badge', $user->id) }}">{{ $index + 1 }}</a>
                                                    </td>
                                                    <td class="td name">
                                                        <a href="{{ route('student-leaderboard.badge', $user->id) }}"
                                                            style="display: flex; align-items: center;">
                                                            @if (!empty($user->avatar) && file_exists(public_path('storage/' . $user->avatar)))
                                                                <img src="{{ asset('storage/' . $user->avatar) }}"
                                                                    alt="{{ $user->name }}"
                                                                    style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-right: 20px;">
                                                            @else
                                                                <img src="{{ asset('images/' . ($user->gender === 'female' ? 'femalAvatar.png' : 'maleAvatar.png')) }}"
                                                                    alt="Default Avatar"
                                                                    style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-right: 20px;">
                                                            @endif
                                                            {{ $user->name }}
                                                        </a>
                                                    </td>
                                                    <td class="td points">
                                                        <a href="{{ route('student-leaderboard.badge', $user->id) }}">
                                                            <div x-data="{ score: 0, target: {{ $user->weekly_points }} }" x-init="setTimeout(() => {
                                                                let interval = setInterval(() => {
                                                                    if (score < target) {
                                                                        score = score + Math.ceil(target / 20);
                                                                        if (score > target) score = target;
                                                                    } else {
                                                                        clearInterval(interval);
                                                                    }
                                                                }, 50);
                                                            }, 1200);"
                                                                x-text="score">
                                                                0
                                                            </div>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </table>
                                    </div>
                                </div>
                                <div style="text-align: center; margin-top: 20px;">
                                    <a href="{{ route('studentLeaderboard.full') }}" class="btn btn-primary"
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



  <style>
        .arrow-right {
            position: relative;
            margin-right: 85px
        }

        .arrow-right::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            border: solid black;
            border-width: 0 4px 4px 0;
            padding: 10px;
            transform: translateY(-50%) rotate(-45deg);
        }

        .badgeImg:hover {
            transform: scale(1.2);
            transition: transform 0.3s ease-in-out;
        }

        .badgeImg {
            margin-bottom: 10px
        }

        .badgeCard {
            flex: 0 0 calc(33.333% - 10px);
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 8px;
            box-sizing: border-box;
        }

        @media (max-width: 768px) {
            p {
                font-size: 12px;
            }

            strong {
                font-size: 14px;
            }

            .badgeCard {
                flex: 0 0 100%;
            }

            .arrow-right {
                position: relative;
                margin-right: 20px
            }
        }
    </style>
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
