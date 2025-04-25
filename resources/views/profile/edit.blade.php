@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl " style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Profile') }}
        </h2>
        <ul class="breadcrumbs">
            @foreach ($breadcrumbs as $breadcrumb)
                <li>
                    <a style="color: #3b1e54;" href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                </li>
            @endforeach
        </ul>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white  " style="margin-top: 50px; height: 80vh;">
            <div class="max-w-5xl mx-auto">
                @include('profile.partials.information')
            </div>
            <button class="btn" id="editProfileBtn" style="margin-top: 50vh;background-color: #3b1e54;color:white">
                Edit Profile
            </button>
        </div>
    </div>

    <div id="editSection" style="display: none;height: 220vh">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white  shadow sm:rounded-lg" style="margin-top: 50px;">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white  shadow sm:rounded-lg">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white  shadow sm:rounded-lg">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <script>
          document.addEventListener("DOMContentLoaded", function () {
        let editSection = document.getElementById("editSection");
        let editButton = document.getElementById("editProfileBtn");

        if (localStorage.getItem("editSectionVisible") === "true") {
            editSection.style.display = "grid";
        } else {
            editSection.style.display = "none";
        }

        editButton.addEventListener("click", function () {
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
</x-app-layout>
