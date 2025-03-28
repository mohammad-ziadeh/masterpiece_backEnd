@php
$breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-gray-100" style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Dashboard') }}
        </h2>
        <ul class="breadcrumbs">
            @foreach ($breadcrumbs as $breadcrumb)
                <li>
                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                </li>
            @endforeach
        </ul>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
