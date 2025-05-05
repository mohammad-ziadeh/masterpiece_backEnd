@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl " style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Submissions') }}
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
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successMessage">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorMessage">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
        <div class="p-4 sm:p-8 bg-white" style="margin-top: 20px; ">

            <div class="row">
                <div class="col grid-margin stretch-card">
                    <div class="card" data-intro="This is the Tasks management table" data-step="1">
                        <div class="card-body">

                            {{-- Start Filters --}}
                            <form method="GET" action="{{ route('submissions.index') }}" class="mb-3 mt-4">
                                <div class="row">

                                    <div class="col-md-3 mb-2">
                                        <select name="task_id" class="form-control" style="border-radius: 5px;">
                                            <option value="">-- Select Task --</option>
                                            @foreach ($tasks as $task)
                                                <option value="{{ $task->id }}"
                                                    {{ request('task_id') == $task->id ? 'selected' : '' }}>
                                                    {{ $task->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <input type="text" name="user_name" class="form-control"
                                            style="border-radius: 5px;" placeholder="Search Student Name"
                                            value="{{ request('user_name') }}">
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        <select name="sort" class="form-control" style="border-radius: 5px;">
                                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>
                                                Descending</option>
                                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>
                                                Ascending</option>

                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-2 d-flex align-items-center">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('submissions.index') }}"
                                            class="btn btn-secondary ml-2">Reset</a>
                                    </div>

                                </div>
                            </form>

                            {{-- End Filters --}}
                            <form action="{{ route('submissions.update.grade') }}" method="POST">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-bordered border-primary">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Task Name (ID)</th>
                                                <th>Student Name (ID)</th>
                                                <th style="width: 10%">Grade</th>
                                                <th>Feedback</th>
                                                <th>Graded By</th>
                                                <th>Submitted At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($submissions as $submission)
                                                <tr>
                                                    <td>{{ $submission->id }}</td>
                                                    <td>
                                                        {{ $submission->task?->name }} ({{ $submission->task?->id }})
                                                    </td>
                                                    <td>
                                                        {{ $submission->user?->name }}
                                                        ({{ $submission->user?->id ?? 'N/A' }}) </td>
                                                    @if ($submission->grade === 'pending')
                                                        <td style="background-color: rgb(236, 236, 0)">
                                                        @elseif ($submission->grade === 'passed')
                                                        <td style="background-color: green">
                                                        @else
                                                        <td style="background-color: red">
                                                    @endif
                                                    <select name="grades[{{ $submission->id }}]"
                                                        class="form-control form-control-sm">
                                                        @foreach (['pending', 'passed', 'failed'] as $status)
                                                            <option value="{{ $status }}"
                                                                {{ $submission->grade === $status ? 'selected' : '' }}>
                                                                {{ ucfirst($status) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    </td>
                                                    <td>
                                                        <textarea name="feedback[{{ $submission->id }}]" class="form-control form-control-sm" rows="2"
                                                            placeholder="Write feedback here">{{ old('feedback.' . $submission->id, $submission->feedback) }}</textarea>
                                                    </td>
                                                    <td>
                                                        @if ($submission->approved_by)
                                                            {{ $submission->approvedBy?->name }}
                                                            ({{ $submission->approvedBy?->role }})
                                                        @else
                                                            Not graded yet
                                                        @endif
                                                    </td>
                                                    @if ($submission->created_at)
                                                        @if ($submission->task?->due_date < $submission->created_at)
                                                            <td style="color: red;">
                                                                {{ $submission->created_at?->format('Y-m-d H:i') }}
                                                            </td>
                                                        @else
                                                            <td style="color: green;">
                                                                {{ $submission->created_at?->format('Y-m-d H:i') }}
                                                            </td>
                                                        @endif
                                                    @else
                                                    <td>N/A</td>
                                                    @endif


                                                    <td>
                                                        <a href="{{ route('submissions.show', $submission->id) }}"
                                                            class="btn btn-info">View</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">Edit Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea id="modalFeedbackInput" class="form-control" rows="4" placeholder="Write feedback here..."></textarea>
                    <input type="hidden" id="currentSubmissionId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveFeedback()">Save Feedback</button>
                </div>
            </div>
        </div>
    </div>
    {{-- JavaScript  --}}
    <script>
        let currentSubmissionId = null;

        function openFeedbackModal(submissionId, currentFeedback) {
            currentSubmissionId = submissionId;
            document.getElementById('modalFeedbackInput').value = currentFeedback || '';
            $('#feedbackModal').modal('show');
        }

        function saveFeedback() {
            const feedback = document.getElementById('modalFeedbackInput').value;
            if (!currentSubmissionId) return;

            // Update hidden input value for that submission
            document.querySelector(`#feedbackInput-${currentSubmissionId}`).value = feedback;
            $(`#feedbackDisplay-${currentSubmissionId}`).text(feedback ? 'View Feedback' : 'Add Feedback');

            $('#feedbackModal').modal('hide');
        }
    </script>
    <script>
        function startTour() {
            introJs().start();
        }
    </script>

</x-app-layout>
