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

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;"  >
        <div class="p-4 sm:p-8 bg-white" style="margin-top: 20px; border-radius: 8px;" data-intro="Here where the creative starts. Here u can add new badges or delete an existing badge" data-step="1">

            <form action="{{ route('badges.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 flex justify-center items-center">
                @csrf
            
                <div class="text-center max-w-md  " style="width: 60%; background-color: #c1b7c7; padding: 30px; border-radius: 5px;"  data-intro="Here where you create new badge by giving it a Title, Description and Image. Be creative ;)" data-step="2" >
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">Create New Badge</h3>
            
                    <div class="mb-4" data-intro="Here You add the Title, make it short but meaningful" data-step="3">
                        <label for="title" class="block text-sm font-medium text-gray-700" >Badge Title</label>
                        <input type="text" name="title" id="title" required style="width: 100%" placeholder="Add title here"
                            class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
            
                    <div class="mb-4" data-intro="Here You add the Description, show the students your creativity" data-step="4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3" placeholder="Be creative with the description ;)"
                            class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            style="width: 100%"></textarea>
                    </div>
            
                    <div class="mb-4" data-intro="Here You add the Image, Choose catchy colors badges" data-step="5">
                        <label for="image" class="block text-sm font-medium text-gray-700">Upload Badge Image</label>
                        <input type="file" name="image" id="image" required
                            class="mt-1 block text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                            style="width: 100%">
                    </div>
            
                    <div class="mt-4" data-intro="Click here when you finish creating the badge" data-step="6" >
                        <button type="submit" class="btn btn-primary w-full" style="background-color: #3b1e54; color: white;">
                            Create Badge
                        </button>
                    </div>
                </div>
            </form>
            

        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
        <div class="p-4 sm:p-8 bg-white" style="margin-top: 20px; border-radius: 8px;" data-intro="Here can see all the existing badges, and if you want to change one (just delete it and create new one)" data-step="7">
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
                                        width="90"></td>
                                <td>{{ $badge->title }}</td>
                                <td>{{ $badge->description ?? '—' }}</td>
                                <td>
                                    <form id="delete-form-{{ $badge->id }}" action="{{ route('badges.destroy', $badge->id) }}" method="POST" class="delete-badge-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger"
                                            data-intro="Here You can Delete the badge if you no longer need it"
                                            data-step="8"
                                            onclick="confirmDelete({{ $badge->id }})">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>
    <script>
        function confirmDelete(badgeId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the badge.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${badgeId}`).submit();
                }
            });
        }
    </script>
    <script>
        function startTour() {
            introJs().start();
        }
    </script>
</x-app-layout>
