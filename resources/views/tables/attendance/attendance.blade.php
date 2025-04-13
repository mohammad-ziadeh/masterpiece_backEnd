@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl" style="color: #3b1e54; margin-bottom: 20px;">Daily Attendance &nbsp;&nbsp;
            {{ $date->format('Y-m-d') }}
        </h2>
        <ul class="breadcrumbs">
            @foreach ($breadcrumbs as $breadcrumb)
                <li>
                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                </li>
            @endforeach
        </ul>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success mt-4">{{ session('success') }}</div>
    @endif
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
        <div class="p-4 sm:p-8 bg-white" style="margin-top: 20px;">
            <div class="row">
                <div class="col grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <div style="display: flex; justify-content:space-around; font-size: x-large">
                                <div>Today Absences: {{ $totalAbsent }}</div>
                                <div>Today Tardiness: {{ $totalLate }}</div>
                            </div>




                            <form method="POST" action="{{ route('attendance.store') }}" class="p-6">
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
                                        @foreach ($users as $user)
                                            @php
                                                $attendance = $attendances->get($user->id);
                                                $locked = $attendance && $attendance->locked;
                                                $currentStatus = $attendance->status ?? 'present';
                                            @endphp
                                            <tr>
                                                <td>{{ $user->name }}</td>
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
                                                    <td>
                                                        <input type="number" name="tardiness[{{ $user->id }}]"
                                                            class="form-control" style="border-radius: 5px;"
                                                            placeholder="Minutes late" min="1"
                                                            value="{{ $attendance->tardiness_minutes ?? '' }}"
                                                            {{ $locked ? 'disabled' : '' }}>
                                                    </td>
                                                @elseif ($currentStatus === 'absent')
                                                    <td>
                                                        Absent
                                                    </td>
                                                @else
                                                    <td>
                                                        On Time
                                                    </td>
                                                @endif
                                                <td><input type="text" style="border-radius: 5px;"
                                                        name="description[{{ $user->id }}]" class="form-control"
                                                        placeholder="Optional note"
                                                        value="{{ $attendance->description ?? '' }}"
                                                        {{ $locked ? 'disabled' : '' }}></td>
                                                </td>
                                                <td> <a style="display: grid; justify-content: center;"
                                                        href="{{ route('attendance.history', $user->id) }}">
                                                        <i class="fa-regular fa-calendar-days"
                                                            style="font-size: xx-large"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $users->links('pagination::bootstrap-4') }}
                                    </div>
                                @endif
                                <div class="mt-4">
                                    <button class="btn btn-primary" type="submit">Save Attendance</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        @if (auth()->user()->role === 'admin')
            <div style="display: flex; justify-content: center; gap: 10px; margin-top: 20px; margin-bottom: 20px;">
                <form method="POST" action="{{ route('attendance.lock') }}">
                    @csrf
                    <button class="btn btn-danger" type="submit">Lock Today's Attendance</button>
                </form>
                <form method="POST" action="{{ route('attendance.unlock') }}">
                    @csrf
                    <button class="btn btn-warning" type="submit">Unlock Today's Attendance</button>
                </form>
            </div>
        @endif
</x-app-layout>
