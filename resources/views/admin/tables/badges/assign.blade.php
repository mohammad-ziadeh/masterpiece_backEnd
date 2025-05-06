@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl" style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Assign Badge') }}
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

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successMessage">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Error Message -->
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorMessage">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
        <div class="p-4 sm:p-8 bg-white" style="margin-top: 20px; border-radius: 8px;">

            <h3 class="text-lg font-semibold mb-4">Assign a Badge to a Student</h3>

            <form action="{{ route('badges.assign') }}" method="POST">
                @csrf

                <!-- Select Student -->
                <div class="mb-3">
                    <label for="user_id" class="form-label">Select Student:</label>
                    <select name="user_id" id="user_id" class="form-select w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">-- Choose a Student --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->name }} ({{ $student->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Badge -->
                <div class="mb-3">
                    <label for="badge_id" class="form-label">Select Badge:</label>
                    <select name="badge_id" id="badge_id" class="form-select w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">-- Choose a Badge --</option>
                        @foreach ($badges as $badge)
                            <option value="{{ $badge->id }}">
                                {{ $badge->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary" style="background-color: #3b1e54; color: white;">
                        Assign Badge
                    </button>
                </div>
            </form>
            <a href="{{route('badges.create')}}">cascasc</a>

        </div>
    </div>
</x-app-layout>