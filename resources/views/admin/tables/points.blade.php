<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl " style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
        <div class="p-4 sm:p-8 bg-white" style="margin-top: 20px; ">
            <h1>Points for {{ $user->name }}</h1>

            <p>Weekly Points: {{ $user->weekly_points }}</p>

            <a href="{{ route('users.index') }}">Back to Users List</a>

        </div>
    </div>
    
</x-app-layout>
