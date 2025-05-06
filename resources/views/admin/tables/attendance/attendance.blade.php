@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl" style="color: #3b1e54; margin-bottom: 20px;">Daily Attendance &nbsp;&nbsp;
            {{ $date->format('Y-m-d') }}
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

    @if (session('success'))
        <div class="alert alert-success mt-4">{{ session('success') }}</div>
    @endif
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
        <div class="p-4 sm:p-8 bg-white" style="margin-top: 20px;">
            <div class="row">
                <div class="col grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body" data-intro="This is the Attendance management table" data-step="1">

                            <div style="display: flex; justify-content:space-around; font-size: x-large">
                                <div data-intro="Here you can see the total of today Absences" data-step="2">Today
                                    Absences: {{ $totalAbsent }}</div>
                                <div data-intro="Here you can see the total of today Tardiness" data-step="3">Today
                                    Tardiness: {{ $totalLate }}</div>
                            </div>


                            <form method="GET" action="{{ route('attendance.index') }}" class="mb-3 mt-4"
                                data-intro="These are the filters, here u can filter the Attendance according users Name and Role"
                                data-step="4">
                                <div class="row">
                                    <div class="col-md-2">
                                        <input type="text" name="name" class="form-control"
                                            style="border-radius: 5px" placeholder="Search Name"
                                            value="{{ request('name') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="role" class="form-control">
                                            <option value="all">All Roles</option>
                                            <option value="student"
                                                {{ request('role') == 'student' ? 'selected' : '' }}>Student</option>
                                            <option value="trainer"
                                                {{ request('role') == 'trainer' ? 'selected' : '' }}>Trainer</option>
                                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                                                Admin</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 ">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                    <a class="btn btn-primary" style="margin-left: auto; margin-right: 15px;"
                                        href="{{ route('attendanceHistory.index') }}"
                                        data-intro="Here you can see yesterday Attendance history of all users and change their attendance status (You can Only see one previous day)"
                                        data-step="5">Attendance History</a>
                                </div>
                            </form>


                            <form method="POST" action="{{ route('attendance.store') }}">
                                @csrf
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            @if (auth()->user()->role === 'admin')
                                                <th data-intro="Here you can see the user name with his role"
                                                    data-step="6">Name (Role)</th>
                                            @else
                                                <th data-intro="Here you can see the student name" data-step="6">Name
                                                    (Role)
                                                </th>
                                            @endif

                                            @if (auth()->user()->role === 'admin')
                                                <th data-intro="Here you change the Attendance status of the user (click save after changing to save the change)"
                                                    data-step="7">Status</th>
                                            @else
                                                <th data-intro="Here you change the Attendance status of the student (click save after changing to save the change)"
                                                    data-step="7">Status</th>
                                            @endif
                                            <th data-intro="When the status is changed to late, here u will see a input that you put the amount of latency time. otherwise you will see the status"
                                                data-step="8">Tardiness Time</th>
                                            <th data-intro="If there is a note about the Attendance status change u can add it here, otherwise u can leave it empty"
                                                data-step="9">Note</th>

                                            @if (auth()->user()->role === 'admin')
                                                <th data-intro="Here by clicking on the calender u will see the user attendance history from the first he joined"
                                                    data-step="10">Attending History</th>
                                            @else
                                                <th data-intro="Here by clicking on the calender u will see the student attendance history from the first he joined"
                                                    data-step="10">Attending History</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (auth()->user()->role === 'admin')
                                            @foreach ($users as $user)
                                                @php
                                                    $attendance = $attendances->get($user->id);
                                                    $locked = $attendance && $attendance->locked;
                                                    $currentStatus = $attendance->status ?? 'present';
                                                @endphp
                                                <tr>
                                                    <td>{{ $user->id }}</td>
                                                    @if ($user->role === 'trainer')
                                                        <td style="background-color: #D4BEE4">
                                                            {{ $user->name }} (Trainer)</td>
                                                    @elseif ($user->role === 'student')
                                                        <td style="background-color:#EEEEEE">
                                                            {{ $user->name }} (Student)</td>
                                                    @endif
                                                    <td>
                                                        <select name="attendances[{{ $user->id }}]"
                                                            class="form-control" {{ $locked ? 'disabled' : '' }}>
                                                            @foreach (['present', 'absent', 'late', 'excused'] as $status)
                                                                <option value="{{ $status }}"
                                                                    {{ $currentStatus == $status ? 'selected' : '' }}>
                                                                    {{ ucfirst($status) }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </td>
                                                    @if ($currentStatus === 'late')
                                                        <td style="color: orange;">
                                                            <input type="number" name="tardiness[{{ $user->id }}]"
                                                                class="form-control" style="border-radius: 5px;"
                                                                placeholder="Minutes late" min="1"
                                                                value="{{ $attendance->tardiness_minutes ?? '' }}"
                                                                {{ $locked ? 'disabled' : '' }}>
                                                        </td>
                                                    @elseif ($currentStatus === 'absent')
                                                        <td style="color: red">
                                                            Absent
                                                        </td>
                                                    @else
                                                        <td style="color: green">
                                                            On Time
                                                        </td>
                                                    @endif
                                                    <td style="display: grid">
                                                        @php $inputId = 'desc_' . $user->id; @endphp
                                                        <input type="text" style="border-radius: 5px;"
                                                            id="{{ $inputId }}"
                                                            name="description[{{ $user->id }}]"
                                                            class="form-control" placeholder="Optional note"
                                                            maxlength="1000" oninput="updateCounter(this)"
                                                            value="{{ $attendance->description ?? '' }}"
                                                            {{ $locked ? 'disabled' : '' }}>
                                                        <small id="{{ $inputId }}-counter"
                                                            style="text-align: right; color: gray;">
                                                            {{ strlen($attendance->description ?? '') }} / 1000
                                                        </small>
                                                    </td>
                                                    </td>
                                                    <td> <a style="display: grid; justify-content: center;"
                                                            href="{{ route('attendance.history', $user->id) }}">
                                                            <i class="fa-regular fa-calendar-days"
                                                                style="font-size: xx-large"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach ($students as $user)
                                                @php
                                                    $attendance = $attendances->get($user->id);
                                                    $locked = $attendance && $attendance->locked;
                                                    $currentStatus = $attendance->status ?? 'present';
                                                @endphp
                                                <tr>
                                                    <td style="background-color:#EEEEEE">
                                                        {{ $user->name }} (Student)</td>
                                                    <td>
                                                        <select name="attendances[{{ $user->id }}]"
                                                            class="form-control" {{ $locked ? 'disabled' : '' }}>
                                                            @foreach (['present', 'absent', 'late', 'excused'] as $status)
                                                                <option value="{{ $status }}"
                                                                    {{ $currentStatus == $status ? 'selected' : '' }}>
                                                                    {{ ucfirst($status) }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </td>
                                                    @if ($currentStatus === 'late')
                                                        <td style="color: orange">
                                                            <input type="number"
                                                                name="tardiness[{{ $user->id }}]"
                                                                class="form-control" style="border-radius: 5px;"
                                                                placeholder="Minutes late" min="1"
                                                                value="{{ $attendance->tardiness_minutes ?? '' }}"
                                                                {{ $locked ? 'disabled' : '' }}>
                                                        </td>
                                                    @elseif ($currentStatus === 'absent')
                                                        <td style="color: red">
                                                            Absent
                                                        </td>
                                                    @else
                                                        <td style="color: green">
                                                            On Time
                                                        </td>
                                                    @endif
                                                    <td style="display: grid">
                                                        @php $inputId = 'desc_' . $user->id; @endphp
                                                        <input type="text" style="border-radius: 5px;"
                                                            id="{{ $inputId }}"
                                                            name="description[{{ $user->id }}]"
                                                            class="form-control" placeholder="Optional note"
                                                            maxlength="1000" oninput="updateCounter(this)"
                                                            value="{{ $attendance->description ?? '' }}"
                                                            {{ $locked ? 'disabled' : '' }}>
                                                        <small id="{{ $inputId }}-counter"
                                                            style="text-align: right; color: gray;">
                                                            {{ strlen($attendance->description ?? '') }} / 1000
                                                        </small>
                                                    </td>
                                                    </td>
                                                    <td> <a style="display: grid; justify-content: center;"
                                                            href="{{ route('attendance.history', $user->id) }}">
                                                            <i class="fa-regular fa-calendar-days"
                                                                style="font-size: xx-large"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $users->links('pagination::bootstrap-4') }}
                                    </div>
                                @endif
                                <div class="mt-4">
                                    <button class="btn btn-primary" type="submit"
                                        data-intro="This is the save button, By clicking on it u will save the changes of (THIS PAGE ONLY)."
                                        data-step="11">Save Attendance</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <script>
            function updateCounter(input) {
                const counter = document.getElementById(input.id + '-counter');
                counter.textContent = `${input.value.length} / ${input.maxLength}`;
            }
        </script>
        <script>
            function startTour() {
                introJs().start();
            }
        </script>
</x-app-layout>
