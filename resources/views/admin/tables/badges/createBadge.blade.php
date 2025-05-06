@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl" style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Create & Manage Badges') }}
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

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
        <div class="p-4 sm:p-8 bg-white" style="margin-top: 20px; border-radius: 8px;">

            <form action="{{ route('badges.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <h3 class="text-lg font-semibold mb-4 text-gray-700">Create New Badge</h3>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Badge Title</label>
                    <input type="text" name="title" id="title" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Upload Badge Image</label>
                    <input type="file" name="image" id="image" required
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                  file:rounded file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100">
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary" style="background-color: #3b1e54; color: white;">
                        Create Badge
                    </button>
                </div>
            </form>

        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
        <div class="p-4 sm:p-8 bg-white" style="margin-top: 20px; border-radius: 8px;">
            <h3 class="text-lg font-semibold mb-4">Existing Badges</h3>

            @if ($badges->isEmpty())
                <p>No badges found.</p>
            @else
                <table class="table table-bordered w-full">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($badges as $badge)
                            <tr>
                                <td><img src="{{ asset('storage/' . $badge->image_url) }}" alt="{{ $badge->title }}"
                                        width="70"></td>
                                <td>{{ $badge->title }}</td>
                                <td>{{ $badge->description ?? '—' }}</td>
                                <td>
                                    <form action="{{ route('badges.destroy', $badge->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this badge?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>
</x-app-layout>
