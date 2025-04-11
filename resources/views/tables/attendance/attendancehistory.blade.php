<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Attendance History for {{ $user->name }}</h2>
    </x-slot>

    <div class="p-6">
        @if (session('success'))
            <div class="alert alert-success mt-4">{{ session('success') }}</div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
            <div class="p-4 sm:p-8 bg-white" style="margin-top: 20px;">
                <div class="row">
                    <div class="col grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="{{ route('attendance.history', $user->id) }}"
                                    class="mb-4">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="from_date" class="form-label">From Date</label>
                                            <input type="date" name="from_date" id="from_date" class="form-control"
                                                max="{{ date('Y-m-d') }}" value="{{ request('from_date') }}">
                                        </div>

                                        <div class="col-md-3">
                                            <label for="to_date" class="form-label">To Date</label>
                                            <input type="date" name="to_date" id="to_date" class="form-control"
                                                max="{{ date('Y-m-d') }}" value="{{ request('to_date') }}">
                                        </div>

                                        <div class="col-md-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="">All</option>
                                                <option value="present"
                                                    {{ request('status') == 'present' ? 'selected' : '' }}>Present
                                                </option>
                                                <option value="absent"
                                                    {{ request('status') == 'absent' ? 'selected' : '' }}>Absent
                                                </option>
                                                <option value="late"
                                                    {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
                                                <option value="excused"
                                                    {{ request('status') == 'excused' ? 'selected' : '' }}>Excused
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </form>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Submitted By</th>
                                            <th>Submitted At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attendanceHistory as $attendance)
                                            <tr>
                                                <td>{{ $attendance->user->name }}</td>
                                                <td>{{ $attendance->date }}</td>
                                                <td>{{ ucfirst($attendance->status) }}</td>
                                                <td>{{ $attendance->submittedBy->name }}</td>
                                                <td>{{ $attendance->submitted_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('attendance.index') }}" class="btn btn-primary">Back to Attendance</a>
        </div>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const fromDate = document.getElementById('from_date');
        const toDate = document.getElementById('to_date');

        fromDate.addEventListener('change', function () {
            toDate.min = fromDate.value;
        });

        toDate.addEventListener('change', function () {
            fromDate.max = toDate.value;
        });
    });
</script>

</x-app-layout>
