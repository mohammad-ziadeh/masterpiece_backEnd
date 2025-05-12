<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $submission->user?->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                style="height: auto; min-height: 80vh; display: flex; flex-wrap: wrap;">

                @if ($submission->pdf_path)
                    <div class="product-img">
                        <iframe src="{{ asset('storage/' . $submission->pdf_path) }}" width="100%" height="100%"
                            style="border-radius: 7px 0 0 7px;"></iframe>
                    </div>

                    <div class="submission-details">
                        <table class="table table-bordered w-full">
                            <tr>
                                <th>Submission ID</th>
                                <td>{{ $submission->id }}</td>
                            </tr>
                            <tr>
                                <th>Task Name (ID)</th>
                                <td> {{ $submission->task?->name }} ({{ $submission->task?->id }})</td>
                            </tr>
                            <tr>
                                <th>Student Name (ID)</th>
                                <td>{{ $submission->user?->name }}
                                    ({{ $submission->user?->id ?? 'N/A' }})</td>
                            </tr>
                            <tr>
                                <th>Answer</th>
                                <td>{{ $submission->answer ?? 'No Answer' }}</td>
                            </tr>
                            <tr>
                                <th>Submitted At</th>
                                @if ($submission->task?->due_date < $submission->created_at)
                                    <td style="color: red;">
                                        {{ $submission->created_at?->format('Y-m-d H:i') ?? 'N/A' }} (Over Due)</td>
                                  
                                @else
                                    <td style="color: green;">
                                        {{ $submission->created_at?->format('Y-m-d H:i') ?? 'N/A' }} (On Time)</td>
                                    
                                @endif

                            </tr>
                            <tr>
                                <th>Grade</th>
                                @if ($submission->grade === 'pending')
                                    <td style="color: grey;"> {{ ucfirst($submission->grade) }}</td>
                                @elseif ($submission->grade === 'passed')
                                    <td style="color: green;"">
                                        {{ ucfirst($submission->grade) }}</td>
                                @else
                                    <td style="color: red;"">
                                        {{ ucfirst($submission->grade) }}</td>
                                @endif

                            </tr>
                            <tr>
                                <th>Feedback</th>
                                <td style="padding: 5px;">
                                    <div
                                        style="max-height: 100px; overflow-y: auto; overflow-x: hidden; word-break: break-word;">
                                        {{ $submission->feedback ?? 'No Feedback' }}
                                    </div>
                                </td>
                            </tr>

                        </table>
                        <a href="{{ route('submissions.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                @else
                    <table class="table table-bordered w-full">
                        <tr>
                            <th>Submission ID</th>
                            <td>{{ $submission->id }}</td>
                        </tr>
                        <tr>
                            <th>Task Name (ID)</th>
                            <td> {{ $submission->task?->name }} ({{ $submission->task?->id }})</td>
                        </tr>
                        <tr>
                            <th>Student Name (ID)</th>
                            <td>{{ $submission->user?->name }}
                                ({{ $submission->user?->id ?? 'N/A' }})</td>
                        </tr>
                        <tr>
                            <th>Answer</th>
                            <td>{{ $submission->answer ?? 'No Answer' }}</td>
                        </tr>
                        <tr>
                            <th>PDF</th>
                            <td>No PDF uploaded</td>
                        </tr>
                        <tr>
                            <th>Submitted At</th>
                            @if ($submission->task?->due_date < $submission->created_at)
                                <td style="color: red;">
                                    {{ $submission->created_at?->format('Y-m-d H:i') ?? 'N/A' }} (Over Due)</td>
                              
                            @else
                                <td style="color: green;">
                                    {{ $submission->created_at?->format('Y-m-d H:i') ?? 'N/A' }} (On Time)</td>
                                
                            @endif

                        </tr>
                        <tr>
                            <th>Grade</th>
                            @if ($submission->grade === 'pending')
                                <td style="color: grey;"> {{ ucfirst($submission->grade) }}</td>
                            @elseif ($submission->grade === 'passed')
                                <td style="color: green;"">
                                    {{ ucfirst($submission->grade) }}</td>
                            @else
                                <td style="color: red;"">
                                    {{ ucfirst($submission->grade) }}</td>
                            @endif

                        </tr>
                        <tr>
                            <th>Feedback</th>
                            <td style="padding: 5px;">
                                <div
                                    style="max-height: 100px; overflow-y: auto; overflow-x: hidden; word-break: break-word;">
                                    {{ $submission->feedback ?? 'No Feedback' }}
                                </div>
                            </td>
                        </tr>
                    </table>
                    <a style="margin-left: 20px; margin-bottom: 10px;" href="{{ route('submissions.index') }}" class="btn btn-secondary">Back</a>
                @endif

                <a href="{{ route('submissions.index') }}" class="btn btn-secondary mt-3 d-block d-sm-none">Back</a>
            </div>
        </div>
    </div>

    <style>
        .product-img {
            width: 40%;
            height: 110vh;
            float: left;
        }

        .submission-details {
            width: 60%;
            float: right;
            padding: 24px;
            border-left: 1px solid #e5e7eb;
            overflow-y: auto;
        }


        @media (max-width: 768px) {
            .bg-white.overflow-hidden.shadow-sm.sm\:rounded-lg {
                flex-direction: column;
                height: auto;
            }

            .product-img,
            .submission-details {
                width: 100%;
                float: none;
                height: auto;
            }

            .product-img iframe {
                height: 50vh;
                border-radius: 7px 7px 0 0;
            }

            .submission-details {
                border-left: none;
                border-top: 1px solid #e5e7eb;
                padding: 16px;
            }
        }
    </style>
</x-app-layout>
