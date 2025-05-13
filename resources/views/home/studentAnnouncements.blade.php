@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl " style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Users') }}
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
    <div class="mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
        <div class="p-4 sm:p-8 bg-white"
            style="margin-top: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h3 class="mb-4" style="color: #3b1e54; font-size: x-large; font-weight: bold;">Announcements:</h3>
            @forelse ($announcements as $announcement)
                <div class="card mb-3 position-relative d-flex flex-row "
                    style="border-left: 5px solid #3b1e54; background-color: #f9f9f9; border-radius: 8px; margin-left: 100px; margin-right: 100px">
                    <div class="card-body col-md-8">
                        <h1 style="font-size: 34px" class="card-title font-bold">{{ $announcement->title }}</h1>
                        <div class="card-text announcement-body" style="width: 900px">
                            {!! $announcement->body !!}
                            <div class="hr-container">
                                <span>★★★</span>
                            </div>
                            <div style="display: flex; justify-content: space-around;">
                                <div style="font-size: large; font-weight: bold; color: #3b1e54;">Published At:
                                    {{ $announcement->created_at }}</div>
                                <div style="font-size: large; font-weight: bold; color: #3b1e54;">Published By:
                                    {{ $announcement->creator?->name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-container">
                    <span>★★★</span>
                </div>
            @empty
                <p class="text-muted">No announcements yet.</p>
            @endforelse
        </div>
    </div>

    <style>
        .hr-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
        }

        .hr-container::before,
        .hr-container::after {
            content: "";
            flex: 1;
            border-bottom: 2px solid #ccc;
            margin: 0 10px;
        }

        .hr-container span {
            font-size: 18px;
            color: #3b1e54;
        }
    </style>
</x-app-layout>
