@if (auth()->user()->role === 'admin' || auth()->user()->role === 'trainer')
    @php
        $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
    @endphp
@else
    @php
        $breadcrumbs = \App\Helpers\StudentBreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
    @endphp
@endif

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl " style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Profile') }}
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

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white  " style="margin-top: 50px;" data-intro="Here are all of you information that we know about you ;) " data-step="1">
            <div class="max-w-5xl mx-auto">
                @include('profile.partials.information')
            </div>
            @if (auth()->check() && auth()->user()->role === 'admin')
                <button class="btn" id="editProfileBtn" data-intro="Do you want to edit your email and password? Click here " data-step="4"
                    style="margin-top: 50px;background-color: #3b1e54;color:white">
                    Edit profile
                </button>
            @else
                <button class="btn" id="editProfileBtn" data-intro="Do you want to edit your password? Click here " data-step="4"
                    style="margin-top: 50px;background-color: #3b1e54;color:white">
                    Change password
                </button>
            @endif
        </div>
    </div>

    <div id="editSection" style="display: none;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (auth()->check() && auth()->user()->role === 'admin')
                <div class="p-4 sm:p-8 bg-white  shadow sm:rounded-lg" style="margin-top: 50px;">
                    <div class="max-w-xl mx-auto">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white  shadow sm:rounded-lg" style="margin-top: 50px;">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            @if (auth()->check() && auth()->user()->role === 'admin')
                <div class="p-4 sm:p-8 bg-white  shadow sm:rounded-lg">
                    <div class="max-w-xl mx-auto">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let editSection = document.getElementById("editSection");
            let editButton = document.getElementById("editProfileBtn");

            if (localStorage.getItem("editSectionVisible") === "true") {
                editSection.style.display = "grid";
            } else {
                editSection.style.display = "none";
            }

            editButton.addEventListener("click", function() {
                if (editSection.style.display === "none") {
                    editSection.style.display = "grid";
                    localStorage.setItem("editSectionVisible", "true");
                } else {
                    editSection.style.display = "none";
                    localStorage.setItem("editSectionVisible", "false");
                }
            });
        });
    </script>
        <script>
        function startTour() {
            introJs().start();
        }
    </script>
</x-app-layout>
