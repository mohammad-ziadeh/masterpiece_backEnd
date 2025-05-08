@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl " style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Dashboard') }}
        </h2>
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
                <div class="p-6 text-gray-900 ">
                    {{ __("You're logged in!") }}
                </div>

                <div class="container">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <div class="card card-custom text-center p-4" style="background-color: #3b1e54">
                                <div class="icon-circle bg-primary text-white mx-auto">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <h5 class="mb-1" style="color:white">Students</h5>
                                <h3 style="color:white">{{ $students }}</h3>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-custom text-center p-4" style="background-color: #3b1e54">
                                <div class="icon-circle bg-warning text-white mx-auto">
                                    <i class="bi bi-person-badge-fill"></i>
                                </div>
                                <h5 class="mb-1" style="color:white">Trainers</h5>
                                <h3 style="color:white">{{ $trainers }}</h3>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-custom text-center p-4" style="background-color: #3b1e54">
                                <div class="icon-circle bg-success text-white mx-auto">
                                    <i class="bi bi-person-gear"></i>
                                </div>
                                <h5 class="mb-1" style="color:white">Admins</h5>
                                <h3 style="color:white">{{ $admins }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container" style="margin-bottom: 40px">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card card-custom text-center p-4" style="background-color: #3b1e54">
                                <div class="icon-circle bg-danger text-white mx-auto">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                </div>
                                <h5 class="mb-1" style="color:white">Today Absences</h5>
                                <h3 style="color:white">{{ $totalAbsent }}</h3>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-custom text-center p-4" style="background-color: #3b1e54">
                                <div class="icon-circle bg-danger text-white mx-auto">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                </div>
                                <h5 class="mb-1" style="color:white">Today Lateness's</h5>
                                <h3 style="color:white">{{ $totalLate }}</h3>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 40px">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                {{-- // table progress // --}}
                <div class="col-lg-12 grid-margin stretch-card" style="margin-bottom: 40px; margin-top: 40px; ">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Task Completion Progress</h4>
                            <div class="table-responsive pt-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Task Name</th>
                                            <th style="width: 25%">Progress</th>
                                            <th>Students Submissions</th>
                                            <th>Deadline</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tasks as $index => $task)
                                            @php
                                                $percentage =
                                                    $task->students_count > 0
                                                        ? ($task->completed_by_students / $task->students_count) * 100
                                                        : 0;
                                            @endphp
                                            <tr>
                                                <td>{{ $task->id }}</td>
                                                <td>{{ $task->name }}</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: {{ $percentage }}%;"
                                                            aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $task->completed_by_students }} / {{ $task->students_count }}
                                                </td>
                                                @if ($task->due_date < $date)
                                                <td style="color: red;">
                                                        {{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d H:i') }}
                                                    </td>
                                                @else
                                                <td style="color: green;">
                                                    {{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d H:i') }}
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- // End table progress // --}}

            </div>

        </div>
    </div>
    <style>
        .card-custom {
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
    </style>
</x-app-layout>
