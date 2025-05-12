@php
    $breadcrumbs = \App\Helpers\StudentBreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl" style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Available Tasks') }}
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
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 40px">
        <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg" style="padding: 20px">
            @if ($tasks->isEmpty())
                <p class="text-gray-500">No Tasks yet.</p>
            @else
                <ul style="list-style: none; padding-left: 0;">
                    @foreach ($tasks as $task)
                        <li
                            style="margin: 20px 0; padding: 15px; border: 2px solid #D4BEE4; border-radius: 12px; display: flex; justify-content: space-between; background-color: #f8f8f8;">
                            <div style="flex-grow: 1;">
                                <strong style="font-size: 1.2rem; color: #3b1e54;">{{ $task->name }}</strong>
                                <p style="color: #3b1e54; margin-top: 5px;">
                                    @if ($task->due_date > $now)
                                        <span style="color: gray; font-weight: bold;">Due by:</span>
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }} at
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('h:i A') }}
                                    @else
                                        <span style="color: red; font-weight: bold;">Overdue:
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }} at
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('h:i A') }}</span>
                                    @endif
                                </p>
                            </div>

                            <!-- Link to View Task Details -->
                            <a href="{{ route('studentSubmissions.show', $task->id) }}"
                                style="background-color: #3b1e54; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; align-self: center;">
                                View Task Details
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif


        </div>
    </div>
</x-app-layout>
