@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl " style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Dashboard') }}
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

    <div class="py-12" style="height: 100%"  data-intro="Here is the Dashboard. Here you can see all the general information and statistics about the LMC." data-step="1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg" data-intro="Here is User Summary Cards. Here you see can the number of students, trainers, admins, and general information like Absences and Tardiness." data-step="2">
                <div class="p-6 text-gray-900 ">
                    {{ __("You're logged in!") }}
                </div>

                <div class="container" >
                    <div class="row g-3" >

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
                                <h5 class="mb-1" style="color:white">Today Tardiness</h5>
                                <h3 style="color:white">{{ $totalLate }}</h3>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- // table progress // --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 40px">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg" data-intro="Here Tasks Summary Table. Here you can see the tasks summary like if the deadline ended (red text) or the student still have time (green text), and u can see how many student should submit the task and how many already did." data-step="3">
                <div class="col-lg-12 grid-margin stretch-card" style="margin-bottom: 40px; margin-top: 40px; ">
                    <h4 class="card-title">Task Completion Progress</h4>
                    <div class="table-responsive pt-3">
                        <div class="table-responsive">
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
                                        @if ($task->due_date < $now)
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
                         <div class="d-flex justify-content-center mt-3">
                                {{ $tasks->links('pagination::bootstrap-4') }}
                            </div>
                    </div>
                </div>
                {{-- // End table progress // --}}

            </div>

        </div>

        {{-- // Attendance data // --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 40px">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg" data-intro="This is the Weekly Attendance Report. It shows the percentage of students marked present, late, or absent for each day of the week." data-step="4">

                <canvas id="weekly-attendance-chart" style="padding: 40px;" class="mt-3"></canvas>

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

         @media (max-width: 768px) {
        h2 {
            font-size: 1.5rem;
        }

        h3, h5, .card-custom h3, .card-custom h5 {
            font-size: 1.1rem !important;
        }

        .icon-circle {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }

        .text-gray-900 {
            font-size: 1rem;
        }

        .breadcrumbs a {
            font-size: 0.9rem;
        }

        /* Table improvements */
        .table-responsive {
            overflow-x: auto;
        }

       .table {
            font-size: 1.1rem !important;
        }

        .table th, table td {
            padding: 0.75rem !important;
        }
    }

    @media (max-width: 480px) {
        h3, h5 {
            font-size: 1rem !important;
        }

        .icon-circle {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }

        .breadcrumbs {
            flex-direction: column;
            gap: 4px;
        }

         .table {
            font-size: 1.25rem !important;
        }

        .table th, table td {
            padding: 1rem !important;
        }
    }
    </style>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const attendanceData = @json($attendanceData);
        const labels = Object.keys(attendanceData);
        const attended = labels.map(day => attendanceData[day].attended);
        const late = labels.map(day => attendanceData[day].late);
        const absent = labels.map(day => attendanceData[day].absent);

        const ctx = document.getElementById('weekly-attendance-chart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Attended',
                        data: attended,
                        backgroundColor: '#3B1E54',
                    },
                    {
                        label: 'Late',
                        data: late,
                        backgroundColor: '#9B7EBD',
                    },
                    {
                        label: 'Absent',
                        data: absent,
                        backgroundColor: '#E0E0E0',
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
        <script>
        function startTour() {
            introJs().start();
        }
    </script>
</x-app-layout>
