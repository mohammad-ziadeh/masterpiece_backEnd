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
                        Start:
                        <span class="ag-courses-item_date">
                            30.11.2022
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
                        Start:
                        <span class="ag-courses-item_date">
                            30.11.2022
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
                        Start:
                        <span class="ag-courses-item_date">
                            30.11.2022
                        </span>
                    </div>
                </a>
            </div>


            <div class="ag-courses_item">
                <a href="{{ route('leaderBoard.index') }}" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        Leader Board
                    </div>

                    <div class="ag-courses-item_date-box">
                        Start:
                        <span class="ag-courses-item_date">
                            30.11.2022
                        </span>
                    </div>
                </a>
            </div>


            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        Motion Design
                    </div>

                    <div class="ag-courses-item_date-box">
                        Start:
                        <span class="ag-courses-item_date">
                            30.11.2022
                        </span>
                    </div>
                </a>
            </div>


            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        Motion Design
                    </div>

                    <div class="ag-courses-item_date-box">
                        Start:
                        <span class="ag-courses-item_date">
                            30.11.2022
                        </span>
                    </div>
                </a>
            </div>


            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        Motion Design
                    </div>

                    <div class="ag-courses-item_date-box">
                        Start:
                        <span class="ag-courses-item_date">
                            30.11.2022
                        </span>
                    </div>
                </a>
            </div>


            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        Motion Design
                    </div>

                    <div class="ag-courses-item_date-box">
                        Start:
                        <span class="ag-courses-item_date">
                            30.11.2022
                        </span>
                    </div>
                </a>
            </div>


            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                        Motion Design
                    </div>

                    <div class="ag-courses-item_date-box">
                        Start:
                        <span class="ag-courses-item_date">
                            30.11.2022
                        </span>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <script>
        function startTour() {
            introJs().start();
        }
    </script>
</x-app-layout>
