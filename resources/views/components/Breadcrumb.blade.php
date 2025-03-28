<nav aria-label="Breadcrumb" class="bg-gray-100 p-4 rounded-md">
    <ol class="list-reset flex text-sm text-gray-700">
        <li>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Home</a>
        </li>
        @foreach ($breadcrumbs as $breadcrumb)
            <li class="mx-2">/</li>
            <li>
                <a href="{{ $breadcrumb['url'] }}" class="text-blue-600 hover:text-blue-800">{{ $breadcrumb['label'] }}</a>
            </li>
        @endforeach
    </ol>
</nav>
