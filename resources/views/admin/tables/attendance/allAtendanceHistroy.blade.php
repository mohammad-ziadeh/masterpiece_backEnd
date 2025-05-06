@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl" style="color: #3b1e54; margin-bottom: 20px;">Yesterday Attendance &nbsp;&nbsp;
            {{ $pastDate->format('Y-m-d') }}
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
                        <div class="card-body" data-intro="This is the Yesterday Attendance table" data-step="1">

                            <div class="mb-4">
                                @if (request('view') === 'all')
                                    <a href="{{ route('attendanceHistory.index', request()->except('view')) }}"
                                        data-intro="Here you can change between showing all the users at once or 10 per page"
                                        data-step="2" class="btn btn-primary">
                                        Show Paginated
                                    </a>
                                @else
                                    <a href="{{ route('attendanceHistory.index', array_merge(request()->all(), ['view' => 'all'])) }}"
                                        data-intro="Here you can change between showing all the users at once or 10 per page"
                                        data-step="2" class="btn btn-primary">
                                        Show All
                                    </a>
                                @endif
                            </div>


                            <form method="GET" action="{{ route('attendanceHistory.index') }}" class="mb-3 mt-4">
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
                                        <a href="{{ route('attendanceHistory.index') }}"
                                            class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>


                            <form method="POST" action="{{ route('attendanceHistory.store') }}" class="p-6">
                                @csrf
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Tardiness Time</th>
                                            <th>Note</th>
                                            <th>Attending History</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (auth()->user()->role === 'admin')
                                            @foreach ($users as $user)
                                                @php
                                                    $attendance = $yesterdayAttendances->get($user->id);
                                                    $locked = $attendance && $attendance->locked;
                                                    $currentStatus = $attendance->status ?? 'present';
                                                @endphp
                                                <tr>
                                                    @if ($user->role === 'trainer')
                                                        <td style="background-color: #D4BEE4">
                                                            {{ $user->name }} (Trainer)</td>
                                                    @elseif ($user->role === 'student')
                                                        <td style="background-color:#EEEEEE">
                                                            {{ $user->name }} (Student)</td>
                                                    @endif
                                                    <td>
                                                        <select name="yesterdayAttendances[{{ $user->id }}]"
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
                                        @elseif (auth()->user()->role === 'trainer')
                                            @foreach ($students as $user)
                                                @php
                                                    $attendance = $yesterdayAttendances->get($user->id);
                                                    $locked = $attendance && $attendance->locked;
                                                    $currentStatus = $attendance->status ?? 'present';
                                                @endphp
                                                <tr>
                                                    @if ($user->role === 'student')
                                                        <td style="background-color:#EEEEEE">
                                                            {{ $user->name }} (Student)</td>
                                                    @endif
                                                    <td>
                                                        <select name="yesterdayAttendances[{{ $user->id }}]"
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
                                        @endif
                                    </tbody>
                                </table>
                                @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $users->links('pagination::bootstrap-4') }}
                                    </div>
                                @endif
                                <div class="mt-4" class="mt-4">
                                    <button class="btn btn-primary" type="submit"
                                        data-intro="This is the save button, By clicking on it u will save the changes of (THIS PAGE ONLY). If u want to save the changes of all the pages u have to click on (Show all) button and then save"
                                        data-step="3">Save Attendance</button>
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
