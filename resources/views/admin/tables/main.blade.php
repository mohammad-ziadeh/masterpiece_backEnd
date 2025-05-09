@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl " style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Tables') }}
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

    <div class="ag-format-container"
        data-intro="Welcome to tables. Here u can find all the tables that u need to manage everything with ease "
        data-step="1">
        <div class="ag-courses_box">

            <div class="ag-courses_item" data-intro="This is the Users table, here u can find all the needed information about your users and update them"
            data-step="2">
                <a href="{{ route('users.index') }}" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        Users Table
                    </div>

                    <div class="ag-courses-item_date-box">
                        Your Role:
                        <span class="ag-courses-item_date">
                            {{ Auth::user()->role }}
                        </span>
                    </div>
                </a>
            </div>


            <div class="ag-courses_item" class="ag-courses_item" data-intro="This is the Tasks table, here u can manage, create and assign tasks to the students"
            data-step="3">
                <a href="{{ route('tasks.index') }}" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        Tasks Table
                    </div>

                    <div class="ag-courses-item_date-box">
                       Finished Tasks:
                        <span class="ag-courses-item_date">
                            {{$finishedTasks}}
                        </span>
                    </div>
                </a>
            </div>


            <div class="ag-courses_item" class="ag-courses_item" class="ag-courses_item" data-intro="This is the Attendance table, here u can manage, Attendance and see the Attendance history for each user"
            data-step="4">
                <a href="{{ route('attendance.index') }}" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        Attendance Table
                    </div>

                    <div class="ag-courses-item_date-box">
                        Today Absences:
                        <span class="ag-courses-item_date">
                           {{$totalAbsent}}
                        </span>
                    </div>
                </a>
            </div>


            <div class="ag-courses_item" data-intro="This is the Leader Board, here u can see the top preforming students this week"
            data-step="5">
                <a href="{{ route('leaderBoard.index') }}" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        Leader Board
                    </div>

                    <div class="ag-courses-item_date-box">
                        Top 1 Student:
                        <span class="ag-courses-item_date">
                           {{$topUsers->name}}
                        </span>
                    </div>
                </a>
            </div>


            <div class="ag-courses_item" data-intro="This is the Submissions table, here u can all the Submissions from the students and change the status of the submission."
            data-step="6">
                <a href="{{route('submissions.index')}}" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        Submissions
                    </div>

                    <div class="ag-courses-item_date-box">
                        Last Task Completion:
                        <span class="ag-courses-item_date">
                            {{ number_format($task->completion_percentage, 2) }}%
                        </span>
                    </div>
                </a>
            </div>


            <div class="ag-courses_item" data-intro="Here you can assign badges to the students and create new one or delete an existing one."
            data-step="7">
                <a href="{{route('badges.assign')}}" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        Badges
                    </div>

                    <div class="ag-courses-item_date-box">
                        Till Next Badge:
                        <span id="weeklyCountdown" class="ag-courses-item_date">
                           
                        </span>
                    </div>
                </a>
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
                `${days}d ${hours}h ${minutes}m ${seconds}s`;
        }

        setInterval(updateWeeklyCountdown, 1000);
    </script>
    <script>
        function startTour() {
            introJs().start();
        }
    </script>
</x-app-layout>
